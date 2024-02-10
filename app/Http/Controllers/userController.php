<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\HttpResponses;
// use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Hash;
use Carbon\Carbon;

class userController extends Controller
{
    use HttpResponses;
    //
    public function index(){
        $users = User::all();
        return $this->success([
            'data' => $users
           ]);
    }

    public function searchUser(Request $request) {
        // $keyword = $request->input('keyword');
        $results = User::latest()->filter(request(['keyword']))->get();
        return $this->success([
            'data' => $results
           ]);
    }

    public function store(Request $request){
        try {
            $user = new User;
            $user->username = trim($request->username);
            $user->tel = trim($request->tel);
            $user->password = trim($request->password);
            $user->email = trim($request->email);
            $user->country = $request->country;
            $user->packageId = $request->packageId ?? "1";
            $res = $user->save();
    
            if ($res) {
                return $this->success([
                    'user' => $user,
                    'token' => $user->createToken('accessToken' . $user->username)->plainTextToken
                ]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            
            if ($errorCode == 1062) { // MySQL duplicate key error code
                return $this->error('error', 'Username is already taken.', 400);
            } else {
                return $this->error('Database error.');
            }
        }
     }


     public function login(Request $request){
        $credentials = array_map('trim', $request->only('username', 'password'));

        if(!Auth::attempt($credentials)){
            return $this->error('','Credentials do not match', 401);
        }

        $user = User::where('username', $request->username)->first();
        // Set the expiration time for the token (e.g., 1 hour from now)
        return $this->success([
            'user'=>$user,
            'token'=>$user->createToken('accessToken'.$user->username)->plainTextToken
        ]);
    }

    public function deleteUser(Request $request){
        $res = User::where('id', $id)->delete();
        return $this->success([
            'message' => "User deleted Successfully"
        ]);
    }
}
