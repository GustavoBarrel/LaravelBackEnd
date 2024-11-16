<?php

namespace App\Services;

use Carbon\Carbon;
use App\Mail\UserCodeMail;
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
        dd($request);
        // 1 coisa - > validar o token se tiver errado nem continua
        // valida se não ja existe user com esse email
        //

    }


}
