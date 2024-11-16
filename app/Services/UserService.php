<?php

namespace App\Services;

use Carbon\Carbon;
use App\Mail\UserCodeMail;
use App\Models\User;
use App\Models\UserTokens;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserService
{

    public function SendUserLoginValidationTokenByEmail(string $email)
    {
        $code = rand(10000, 99999);

        // estudar tratamento de excessão
        $token = UserTokens::updateOrCreate(
            ['email'=>$email],
            ['email'=>$email,'token'=>Hash::make($code),'expires_at'=>Carbon::now('+00:30'),]
        );

        Mail::to($email)->send(new UserCodeMail($code));
        // estudar tratamento de excessão
        if($token)
        {
            return true;
        }
        return false;

    }

    public function create(Collection $request)
    {
        $token = $request->get('token');
        $email = $request->get('email');

        $userToken = UserTokens::where('email', $email)->first();

        if ($userToken && Hash::check($token, $userToken->token)) {
           $user =  User::create([
                'email'=>$email,
                'email_verified_at'=> Carbon::now(),
                'password'=>Hash::make($request->get('password')),
                'name'=> $request->get('name'),
            ]);

            return $user;
        }
        return false;
    }

    public function redefinirSenha(Collection $request)
    {
        $token = $request->get('token');
        $email = $request->get('email');

        $userToken = UserTokens::where('email', $email)->first();

        if ($userToken && Hash::check($token, $userToken->token)) {
            $user = User::where('email',$email)->first();

            $user->update([
                'password'=> $request->get('new_password'),
            ]);

             return $user;
         }
         return false;
    }

}
