<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\userQuizQuestions;
use App\Models\userQuizMarks;
use App\Models\userQuizInfo;

use Illuminate\Http\Request;

class quizRecordsController extends Controller
{
    use HttpResponses;
    //

    public function store(Request $request)
    {
        $userQuizQuestions = new UserQuizQuestions;
        $userQuizQuestions->quizId = $request->quizId;
        $userQuizQuestions->userId = $request->userId;
        $userQuizQuestions->solvedQuestions = json_encode($request->solvedQuestion);
        $res = $userQuizQuestions->save();

        if ($res) {
            $userQuizInfo = new UserQuizInfo;
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
            $userQuizMark = new UserQuizMarks;
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


    public function quizRecordsOfUser(Request $request){
        $userId = $request->input('userId');
        $userMarks = UserQuizMarks::where('userId', $userId)->get();
        $userRecords = UserQuizInfo::where('userId', $userId)->get();

       return $this->success([
            'marks' => $userMarks,
            'records' => $userRecords
       ]);
    
    }


    public function getRecordReview(Request $request){
        $quizId = $request->input('quizId');
        $questions = UserQuizQuestions::where('quizId', $quizId)->get();
        $userMark = UserQuizMarks::where('quizId', $quizId)->get();
        $userRecord = UserQuizInfo::where('quizId', $quizId)->get();

       return $this->success([
            'questions' => $questions,
            'mark' => $userMark,
            'userInfo' => $userRecord
       ]);
    
    }
  
}
