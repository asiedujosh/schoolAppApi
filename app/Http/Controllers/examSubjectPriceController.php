<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\examSubjectPriceRelation;
use App\Models\paidExamSubjectSubscribers;
use App\Models\duration;
use App\Models\pricing;
use App\Models\subscription;

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


    public function searchDuration(Request $request) {
        // $keyword = $request->input('keyword');
        $results = duration::latest()->filter(request(['keyword']))->get();
        return $this->success([
            'data' => $results
           ]);
    }


    public function searchPricing(Request $request){
        $results = pricing::latest()->filter(request(['keyword']))->get();
        return $this->success([
            'data' => $results
           ]);
    }

    public function searchExamSubjectLink(Request $request){
        $results = examSubjectPriceRelation::latest()->filter(request(['keyword']))->get();
        return $this->success([
            'data' => $results
           ]);
    }


    public function getPurchases(Request $request){
        $userId = $request->userId;
        $purchases = paidExamSubjectSubscribers::where('userId', $userId)->get();
        return $this->success([
            'data' => $purchases
        ]);
    }


    public function getMySubscription(Request $request){
        $userId = $request->userId;
        $mySubscription = subscription::where('userId', $userId)->get();
        return $this->success([
            'data' => $purchases
        ]);
    }


    public function getDuration(Request $request){
        $durations = duration::all();
        return $this->success([
            'data' => $durations
        ]);
    }


    public function getDurationPagination(Request $request){
        $pageNo = $request->input('page');
        $perPage = $request->input('perPage');
        $durations = duration::orderBy('id', 'DESC')->paginate($perPage, ['*'], 'page', $pageNo);
        return $this->success([
            'data' =>  $durations,
            'pagination' => [
                'total' =>  $durations->total(),
                'current_page' =>  $durations->currentPage(),
                'last_page' =>  $durations->lastPage()
            ]
        ]);
    }

    public function getPricingAll(Request $request){
        $pricing = pricing::all();
        return $this->success([
            'data' => $pricing
        ]);
    }


    public function getPricing(Request $request){
        $pageNo = $request->input('page');
        $perPage = $request->input('perPage');
        $pricing = pricing::orderBy('id', 'DESC')->paginate($perPage, ['*'], 'page', $pageNo);
        return $this->success([
            'data' => $pricing,
            'pagination' => [
                'total' => $pricing->total(),
                'current_page' => $pricing->currentPage(),
                'last_page' => $pricing->lastPage()
            ]
        ]);
    }

    // //Get all paid course subject
    // public function getPaidSubject(){
    // $paid = examSubjectPriceRelation::where('offerType', 'paid')->orderBy('created_at', 'desc')->get();
    // return $this->success([
    //     'data' => $paid
    // ]);
    // }


    // Store exam subject Link
    public function store(Request $request){
        $relations = new examSubjectPriceRelation;
        $relations->name = trim($request->name);
        $relations->examId = trim($request->examId);
        $relations->subjectId = trim($request->subjectId);
        $relations->offerType = trim($request->offerType);
        $relations->examTime = trim($request->examTime);
        $res = $relations->save();

        if($res){
            return $this->success([
                'data' => $relations
            ]);
        } 
    }

    // Store Duration
    public function storeDuration(Request $request){
        $duration = new duration;
        $duration->name = trim($request->name);
        $duration->noOfMonths = $request->noOfMonths;
        $res = $duration->save();

        if($res){
            return $this->success([
                'data' => $duration
            ]);
        } 
    }

    //Store Pricing
    public function storePricing(Request $request){
        $pricing = new pricing;
        $pricing->examSubjectId = $request->examSubjectId;
        $pricing->price = $request->pricing;
        $pricing->durationType = $request->durationType;
        $res = $pricing->save();
        if($res){
            return $this->success([
                'data' => $pricing
            ]);
        } 
    }

    // Update Examsubject link
    public function updateExamSubjectLink(Request $request, $id){
        $formField = [
            'examId' => trim($request->examId),
            'subjectId' => trim($request->subjectId),
            'offerType' => trim($request->offerType),
            'examTime' => trim($request->examTime)
        ];

        $res = examSubjectPriceRelation::where('id', $id)->update($formField);
        if($res){
            return $this->success([
                'data' => $res
            ]);
        }
    }

    //Update Duration
    public function updateDuration(Request $request, $id){
        $formField = [
            'name' => trim($request->name),
            'noOfMonths' => trim($request->noOfMonths),
        ];

        $res = duration::where('id', $id)->update($formField);
        if($res){
            return $this->success([
                'data' => $res
            ]);
        }
    }

    //Update Pricing
    public function updatePricing(Request $request, $id){
        $formField = [
            'examSubjectId' => trim($request->examSubjectId),
            'price' => trim($request->pricing),
            'durationType' => trim($request->durationType),
        ];

        $res = pricing::where('id', $id)->update($formField);
        if($res){
            return $this->success([
                'data' => $res
            ]);
        }
    }


    // Delete ExamSubjectLink
    public function deleteExamSubjectLink($id){
        $res = examSubjectPriceRelation::where('id', $id)->delete();
        if($res){
            return $this->success([
                'message' => "Exam deleted Successfully"
            ]); 
        }
    }

    // Delete Duration
    public function deleteDuration($id){
        $res = duration::where('id', $id)->delete();
        if($res){
            return $this->success([
                'message' => "Duration deleted Successfully"
            ]); 
        }
    }

    //Delete Pricing
    public function deletePricing($id){
        $res = pricing::where('id', $id)->delete();
        if($res){
            return $this->success([
                'message' => "Pricing deleted Successfully"
            ]); 
        }
    }


    public function subscribe(Request $request){
        $subscription = new subscription;
        $subscription->userId = $request->userId;
        $subscription->examSubjectId = $request->examSubjectId;
        $subscription->durationType = $request->durationType;
        $subscription->amount = $request->amount;
        $subscription->startDate = $request->startDate;
        $subscription->endDate = $request->endDate;
        $subscription->status = "active";
        $res = $subscription->save();
        if($res){
            return $this->success([
                'data' => $subscription
            ]);
        }
    }


//     public function storePurchases(Request $request){
//     $userId = $request->userId;
//     $data = $request->data;

//     // Use bulk insert for better performance
//     $records = [];

//     foreach ($data as $item) {
//         // Validate required fields
//         if (!isset($item['examId']) || !isset($item['yearId']) || !isset($item['price'])) {
//             return response()->json(['error' => 'Missing required fields'], 400);
//         }

//         // Add the record to the array
//         $records[] = [
//             'userId' => $userId,
//             'examId' => $item['examId'],
//             'yearId' => $item['yearId'],
//             'subjectId' => $item['subjectId'],
//             'amount' => $item['price'],
//         ];
//     }

//     // Bulk insert records
//     // $res = paidExamSubjectSubscribers::insert($records);
//     // if ($res) {
//     //     return $this->success([
//     //         'data' => 'Purchases stored successfully'
//     //     ]);
//     // } else {
//     //     return $this->error([
//     //         'data' => 'Failed to store purchases'
//     //     ]);
//     // }
// }

}
