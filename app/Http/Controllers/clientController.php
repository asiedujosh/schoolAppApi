<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\client;
use App\Models\User;
use App\Traits\HttpResponses;
// use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Hash;
use Carbon\Carbon;

class clientController extends Controller
{
    use HttpResponses;

    public function index(Request $request){
        $pageNo = $request->input('page');
        $perPage = $request->input('perPage');
        $clients = Client::orderBy('id', 'DESC')->paginate($perPage, ['*'], 'page', $pageNo);
        return $this->success([
            'data' => $clients,
            'pagination' => [
                'total' => $clients->total(),
                'current_page' => $clients->currentPage(),
                'last_page' => $clients->lastPage()
            ]
           ]);
    }

    public function searchClient(Request $request) {
        // $keyword = $request->input('keyword');
        $results = Client::latest()->filter(request(['keyword']))->get();
        return $this->success([
            'data' => $results
           ]);
    }

    public function store(Request $request){
        $client = new Client;
        $client->username = trim($request->username);
        $client->password = trim($request->password);
        $client->role = $request->role;
        $client->tel = trim($request->tel);
        $client->email = trim($request->email);
        $res = $client->save();

        if($res){
            return $this->success([
                'data' => $client
            ]);
        } 
    }

    public function updateClient(Request $request, $id){
        $formField = [
            'username' => $request->username,
            'tel' => $request->tel,
            'email' => $request->email,
            'role' => $request->role,
        ];

        $res = Client::where('id', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }

    public function deleteClient($id){
        $res = Client::where('id', $id)->delete();
        return $this->success([
            'message' => "CLient deleted Successfully"
        ]);
    }

    public function login(Request $request){
        $credentials = $request->only('username', 'password');

        $client = Client::where('username', $credentials['username'])->first();

        if (!$client || !Hash::check($credentials['password'], $client->password)) {
            return $this->error('', 'Credentials do not match', 401);
        } else {
            return $this->success([
                'data' => $client,
                'token'=>$client->createToken('accessToken'.$client->username)->plainTextToken
            ]);
        }
    }

    public function getUserDetails(){
        $client = Auth::User(); // Retrieve the authenticated user
        return response()->json(['data' => $client]);
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return $this->success([
            'data' => 'Tokens revoked successfully'
        ]);
    }
}
