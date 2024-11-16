<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function SendUserLoginValidationTokenByEmail(string $email)
    {
        // depois preciso ver de colocar em um validation request . mas nao ta funcionando.
        $validator = Validator::make(['email'=> $email],
        [
            'email' => 'required|email',
        ],
        [
            'email.required' => 'O campo email e obrigatório.',
            'email.email' => 'Por favor, insira um endereço de email válido.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errorList' => $validator->errors()
            ], 417);
        }

        $token = $this->userService->SendUserLoginValidationTokenByEmail($email);
        // preciso ver de como tratar melhor.

        return response()->json(
            ['message' => $token ? 'Token enviado com sucesso' : 'Erro ao enviar o token'],
            $token ? 200 : 500
        );
    }

    public function store(Request $request)
    {
        $validatedData = $request->only(['token', 'email','password','name']);

        // depois preciso ver de colocar em um validation request . mas nao ta funcionando.
        $validator = Validator::make($validatedData,
        [
            'name'=>'required|string|max:250',
            'token' => 'required|numeric|digits:5',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|max:255',
        ],
        [
            'token.required' => 'O campo token e obrigatório.',
            'token.size'=>'o campo token deve ter 5 digitos.',
            'email.required' => 'O campo email e obrigatório.',
            'email.email' => 'Por favor, insira um endereço de email válido.',
            'email.unique' => 'Este email já está em uso.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'name.required'=>'O nome é  obrigatorio.',
            'name.max'=> 'O nome deve ter no maximo 255 caracteres',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errorList' => $validator->errors()
            ], 417);
        }

        $user = $this->userService->create(collect($validatedData));

        if($user)
        {
            return response()->json(['message'=>'Usuario criado com sucesso','data'=> $user]);
        }

        return response()->json(['message'=>'Erro ao criar o usuario.']);

    }

    public function redefinirSenha(Request $request)
    {
        $validatedData = $request->only(['token', 'new_password','email']);

        $validator = Validator::make($validatedData,
        [
            'token' => 'required|numeric|digits:5',
            'new_password' => 'required|string|max:255',
        ],
        [
            'token.required' => 'O campo token e obrigatório.',
            'token.size'=>'o campo token deve ter 5 digitos.',
            'new_password.required' => 'O campo senha é obrigatório.',
            'new_password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'email.required' => 'O campo email e obrigatório.',
            'email.email' => 'Por favor, insira um endereço de email válido.',
            'email.unique' => 'Este email já está em uso.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errorList' => $validator->errors()
            ], 417);
        }

        $user = $this->userService->redefinirSenha(collect($validatedData));

        if($user)
        {
            return response()->json(['message'=>'Senha atualizada com sucesso','data'=> $user]);
        }

        return response()->json(['message'=>'Erro ao atualizar senha']);

    }
}
