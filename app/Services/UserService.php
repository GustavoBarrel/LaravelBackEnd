<?php

namespace App\Services;

use App\Mail\UserCodeMail;
use App\Models\UserTokens;
use Carbon\Carbon;
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


}
