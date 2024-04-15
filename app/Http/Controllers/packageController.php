<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\subscribers;
use App\Models\packagePrice;
use App\Models\User;

use Illuminate\Http\Request;

class packageController extends Controller
{
    use HttpResponses;
    //
    public function index(){
        $packagePrice = packagePrice::all();
        return $this->success([
            'data' => $packagePrice
           ]);
        }

    public function countSubscribers(){
            $countSubscribers = subscribers::count();
            return $this->success([
              'data' => $countSubscribers
            ]);
    }

    public function getCurrentPackage(){
        $packagePrice = packagePrice::first();
        return $this->success([
            'data' => $packagePrice
           ]);
    }

    public function getSubscribers(){
        $subscribers = subscribers::all();
        return $this->success([
            'data' => $subscribers
        ]);
    }

    public function updateClientPackage(Request $request, $id){
        $subscriber = new subscribers;
        $subscriber->name = trim($request->username);
        $subscriber->tel = trim($request->tel);
        $subscriber->package = '2';
        $subscriber->amount = trim($request->amount);
        $res = $subscriber->save();

        if($res){
        $formField = [
            'packageId' => '2',
        ];

        $res = User::where('id', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }
    }

    public function store(Request $request){
        $packagePrice = new packagePrice;
        $packagePrice->packagePrice = trim($request->packagePrice);
        $packagePrice->description = trim($request->description);
        $res =$packagePrice->save();
        if($res){
            return $this->success([
                'data' => $res
                ]);
        }
    }

    public function updatePackage(Request $request, $id){
        $formField = [
            'packagePrice' => $request->packagePrice,
            'description' => $request->description
        ];

        $res = packagePrice::where('id', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }

    public function deletePackage($id){
        $res = packagePrice::where('id', $id)->delete();
        return $this->success([
            'message' => "Package deleted Successfully"
        ]);
    }

}
