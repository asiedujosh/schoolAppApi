<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use App\Models\userOralQuizInfo;
use App\Models\userOralQuizQuestion;
use App\Models\userOralQuizMarks;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class oralQuizRecordsController extends Controller
{
    use HttpResponses;
    //

    public function store(Request $request)
    {
        $userQuizQuestions = new userOralQuizQuestion;
        $userQuizQuestions->quizId = $request->quizId;
        $userQuizQuestions->userId = $request->userId;
        $userQuizQuestions->solvedQuestions = json_encode($request->solvedQuestion);
        $res = $userQuizQuestions->save();

        if ($res) {
            $userQuizInfo = new userOralQuizInfo;
            $userQuizInfo->quizId = $request->quizId;
            $userQuizInfo->userId = $request->userId;
            $userQuizInfo->examsType = $request->quizInfo['examsType'];
            $userQuizInfo->subject = $request->quizInfo['subject'];
            $userQuizInfo->year = $request->quizInfo['year'];
            $userQuizInfo->timer = $request->quizInfo['timer'];
            $userQuizInfo->status = $request->status;
            $res = $userQuizInfo->save();
        }

        if ($request->status == "complete") {
            $userQuizMark = new userOralQuizMarks;
            $userQuizMark->quizId = $request->quizId;
            $userQuizMark->userId = $request->userId;
            $userQuizMark->correctMark = $request->correctAns;
            $userQuizMark->noOfQuestions = $request->totalQues;
            $res = $userQuizMark->save();
        }

        if ($res) {
            return $this->success(['data' => $res]);
        }

        return $this->error('Failed to save quiz data.');
    }

    public function quizOralRecordsOfUser(Request $request){
        $userId = $request->input('userId');
        $userMarks = userOralQuizMarks::where('userId', $userId)->get();
        $userRecords = userOralQuizInfo::where('userId', $userId)->get();

        return $this->success([
            'marks' => $userMarks,
            'records' => $userRecords
        ]);
    }


    public function getOralRecordReview(Request $request){
        $quizId = $request->input('quizId');
        $questions = userOralQuizQuestion::where('quizId', $quizId)->get();
        $userMark = userOralQuizMarks::where('quizId', $quizId)->get();
        $userRecord = userOralQuizInfo::where('quizId', $quizId)->get();

        return $this->success([
            'questions' => $questions,
            'mark' => $userMark,
            'userInfo' => $userRecord
        ]);
    }


    public function deleteOralRecords(Request $request){
        $quizId = $request->data;
        try {
            DB::beginTransaction();

            // Delete oral records from user oralQuizQuestions table
            userOralQuizQuestion::where('quizId', $quizId)->delete();

            // Delete records from userOralQuizQuestion table
            userOralQuizMarks::where('quizId', $quizId)->delete();

            // Delete records from user oral
            userOralQuizInfo::where('quizId', $quizId)->delete();

            DB::commit();

            return $this->success([
                'data' => 'Data deleted successfully'
            ]);
        } catch (\Exception $e) {
            // If an exception occurs, rollback the transaction
            DB::rollBack();
            // Return an error response with the exception message
            return $this->error('An error occured', $e->getMessage(), 500);
        }
    }
}
