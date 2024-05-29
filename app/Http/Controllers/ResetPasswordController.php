<?php

namespace App\Http\Controllers;

use App\Models\ResetCodePassword;
use App\Models\User;
use App\Traits\HttpResponses;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Auth\ResetPasswordRequest;

use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    use HttpResponses;
    /**
     * Change the password (Setp 3)
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request)
    {
      
        $passwordReset = ResetCodePassword::firstWhere('code', $request->code);

        if ($passwordReset) {
            $user = User::firstWhere('email', $passwordReset->email);
            $user->update($request->only('password'));
            $passwordReset->delete();
            return $this->success('true', 'reset password successfull');
        } else {
            return $this->error('false', 'error with code');
        }
    }
}