<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function SendUserLoginValidationTokenByEmail(string $email)
    {

        $token = $this->userService->SendUserLoginValidationTokenByEmail($email);
        // preciso ver de como tratar melhor.
        if ($token)
        {
            return response()->json(['message' => 'Token enviado com sucesso'], 200);
        }
        else
        {
            return response()->json(['message' => 'Erro ao enviar o token'], 500);
        }
    }

    public function store(UserStoreRequest $request)
    {
        $validated = $request->validated();

        $user = $this->userService->create(collect($validated));

        return response()->json(['message'=>'Usuario criado com sucesso','data'=>$user],200);
    }
}
