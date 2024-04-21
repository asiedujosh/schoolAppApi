<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\examSubjectPriceRelation;
use App\Models\paidExamSubjectSubscribers;

use Illuminate\Http\Request;

class examSubjectPriceController extends Controller
{
    use HttpResponses;

    public function mobileIndex(){
        $relations = examSubjectPriceRelation::all();
        return $this->success([
            'data' => $relations
        ]);
    }


    //
    public function index(Request $request){
        $pageNo = $request->input('page');
        $perPage = $request->input('perPage');
        $relations = examSubjectPriceRelation::orderBy('id', 'DESC')->paginate($perPage, ['*'], 'page', $pageNo);
        return $this->success([
            'data' => $relations,
            'pagination' => [
                'total' => $relations->total(),
                'current_page' => $relations->currentPage(),
                'last_page' => $relations->lastPage()
            ]
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

    public function updateExamSubjectLink(Request $request, $id){
        $formField = [
            'examId' => trim($request->examId),
            'yearId' => "all",
            'subjectId' => trim($request->subjectId),
            'offerType' => trim($request->offerType),
            'price' => trim($request->price)
        ];

        $res = examSubjectPriceRelation::where('id', $id)->update($formField);
        if($res){
            return $this->success([
                'data' => $res
            ]);
        }
    }

    public function deleteExamSubjectLink($id){
        $res = examSubjectPriceRelation::where('id', $id)->delete();
        if($res){
            return $this->success([
                'message' => "Exam deleted Successfully"
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
