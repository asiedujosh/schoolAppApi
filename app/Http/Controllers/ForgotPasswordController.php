<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\ResetCodePassword;
use App\Mail\SendCodeResetPassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Traits\HttpResponses;
use App\Http\Requests\Auth\ForgotPasswordRequest;

use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    use HttpResponses;
    /**
     * Send random code to email of user to reset password (Setp 1)
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request)
    {
        // Check whether email exists
        $exists = User::where('email', $request->email)->exists();
        if ($exists) {
            $data = [
                'email' => $request->email,
                'code' => mt_rand(100000, 999999),
                'created_at' => now()
            ];

            $userInfo = User::where('email', $request->email)->first(); 
            if($userInfo){
            $user = $userInfo->username;
            $info = 'Your username is ' . $user . '. Code sent to email.';
            } else {
                return $this->error('false', 'User not found');
            }
    
            // Delete any existing reset codes for this email
            ResetCodePassword::where('email', $request->email)->delete();
            
            // Create a new reset code
            $codeData = ResetCodePassword::create($data);
    
            // Send the reset code email
            try {
                Mail::to($request->email)->send(new SendCodeResetPassword($data['code']));
                return $this->success('true', $info);
            } catch (\Exception $e) {
                return $this->error('false', 'Error sending mail: ' . $e->getMessage());
            }
        } else {
            return $this->error('false', 'Email does not exist');
        }
    }
}