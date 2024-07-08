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
    public function index(Request $request){
        $pageNo = $request->input('page');
        $perPage = $request->input('perPage');
        $users = User::orderBy('id', 'DESC')->paginate($perPage, ['*'], 'page', $pageNo);;
        return $this->success([
            'data' => $users,
            'pagination' => [
                'total' => $users->total(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage()
            ]
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
            $user->tel = $request->tel;
            $user->password = trim($request->password);
            $user->email = trim($request->email);
            $user->country = $request->countryName;
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

    public function updateUser(Request $request, $id){
       $formField = [
            'tel' => $request->tel,
            'email' => $request->email,
            'country' => $request->country
        ];

        $res = User::where('username', $id)->update($formField);
        if($res){
            return $this->success([
                'data' => $res
            ]);
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


    public function updatePassword(Request $request, $id){
        $credentials = array_map('trim', $request->only('username', 'password'));
        if(!Auth::attempt($credentials)){
            return $this->success([
                'data' => false
            ]);
        } else {
            $formField = [
                'password' =>  Hash::make($request->newPassword)
            ];

            $res = User::where('username', $id)->update($formField);
            if($res){
                return $this->success([
                    'data' => true
                ]);
            }
        }
    }


    public function deleteUser(Request $request){
        $res = User::where('id', $id)->delete();
        return $this->success([
            'message' => "User deleted Successfully"
        ]);
    }
}
