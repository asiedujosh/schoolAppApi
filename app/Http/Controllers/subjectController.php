<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\subject;


use Illuminate\Http\Request;

class subjectController extends Controller
{
    //
    use HttpResponses;
    //
    public function index(){
        $subjects = subject::all();
        return $this->success([
            'data' => $subjects
           ]);
    }

    public function searchSubject(Request $request) {
        // $keyword = $request->input('keyword');
        $results = subject::latest()->filter(request(['keyword']))->get();
        return $this->success([
            'data' => $results
           ]);
    }

    public function store(Request $request){
        $subject = new subject;
        $subject->subject = $request->subject;
        $res = $subject->save();

        if($res){
         return $this->success([
             'data' => $subject
            ]);
        }
    }


    public function updateSubject(Request $request, $id){
        $formField = [
            'subject' => $request->subject,
        ];


        $res = subject::where('id', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }

    public function deleteSubject($id){
        $res = subject::where('id', $id)->delete();
        return $this->success([
            'message' => "Exams deleted Successfully"
        ]);
    }
}
