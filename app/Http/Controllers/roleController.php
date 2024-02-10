<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\role;

use Illuminate\Http\Request;

class roleController extends Controller
{
    use HttpResponses;
    //
    public function index(){
        $role = role::all();
        return $this->success([
            'role' => $role
           ]);
    }

    public function store(Request $request){
        $role = new role;
        $role->role = $request->role;
        $role->description = $request->description;
        $res = $role->save();

        if($res){
         return $this->success([
             'role' => $role
            ]);
        }
    }
}
