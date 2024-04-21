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
    public function mobileIndex(){
        $subjects = subject::all();
        return $this->success([
            'data' => $subjects
        ]);
    }


    public function index(Request $request){
        $pageNo = $request->input('page');
        $perPage = $request->input('perPage');
        $subjects = subject::orderBy('id', 'DESC')->paginate($perPage, ['*'], 'page', $pageNo);
        return $this->success([
            'data' => $subjects,
            'pagination' => [
                'total' => $subjects->total(),
                'current_page' => $subjects->currentPage(),
                'last_page' => $subjects->lastPage()
            ]
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
