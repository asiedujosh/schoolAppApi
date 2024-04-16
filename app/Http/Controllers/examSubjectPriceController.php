<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\examSubjectPriceRelation;
use App\Models\paidExamSubjectSubscribers;

use Illuminate\Http\Request;

class examSubjectPriceController extends Controller
{
    use HttpResponses;
    //
    public function index(){
        $relations = examSubjectPriceRelation::all();
        return $this->success([
            'data' => $relations
        ]);
    }


    public function getPurchases(Request $request){
        $userId = $request->userId;
        $purchases = paidExamSubjectSubscribers::where('userId', $userId)->get();
        return $this->success([
            'data' => $purchases
        ]);
    }

    // //Get all paid course subject
    // public function getPaidSubject(){
    // $paid = examSubjectPriceRelation::where('offerType', 'paid')->orderBy('created_at', 'desc')->get();
    // return $this->success([
    //     'data' => $paid
    // ]);
    // }


    public function store(Request $request){
        $relations = new examSubjectPriceRelation;
        $relations->examId = trim($request->examId);
        $relations->yearId = "all";
        $relations->subjectId = trim($request->subjectId);
        $relations->offerType = trim($request->offerType);
        $relations->price = trim($request->price);
        $res = $relations->save();

        if($res){
            return $this->success([
                'data' => $relations
            ]);
        } 
    }


    public function storePurchases(Request $request){
    $userId = $request->userId;
    $data = $request->data;

    // Use bulk insert for better performance
    $records = [];

    foreach ($data as $item) {
        // Validate required fields
        if (!isset($item['examId']) || !isset($item['yearId']) || !isset($item['subjectId']) || !isset($item['price'])) {
            return response()->json(['error' => 'Missing required fields'], 400);
        }

        // Add the record to the array
        $records[] = [
            'userId' => $userId,
            'examId' => $item['examId'],
            'yearId' => $item['yearId'],
            'subjectId' => $item['subjectId'],
            'amount' => $item['price'],
        ];
    }

    // Bulk insert records
    $res = paidExamSubjectSubscribers::insert($records);
    if ($res) {
        return $this->success([
            'data' => 'Purchases stored successfully'
        ]);
    } else {
        return $this->error([
            'data' => 'Failed to store purchases'
        ]);
    }
}

}
