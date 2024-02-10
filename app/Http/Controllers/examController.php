<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\exam;
use Intervention\Image\Facades\Image;

use Illuminate\Http\Request;

class examController extends Controller
{
    use HttpResponses;
    //
    public function index(){
        $exams = exam::all();
        return $this->success([
            'data' => $exams
           ]);
    }

    public function searchExam(Request $request) {
        // $keyword = $request->input('keyword');
        $results = exam::latest()->filter(request(['keyword']))->get();
        return $this->success([
            'data' => $results
           ]);
    }

    public function store(Request $request){
        $examImage = null;
        if ($request->has('imageUpload') && $request->imageUpload !== '') {
            $image = Image::make($request->imageUpload);
            $compressedImage = $image->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('jpg', 80)->encode('data-url');

            $examImage = $compressedImage->encoded;
        }   
        $exam = new exam;
        $exam->exam = $request->examType;
        $exam->examImage = $examImage;
        $exam->position = $request->position;
        $res = $exam->save();

        if($res){
         return $this->success([
             'data' => $exam
            ]);
        }
    }

    public function updateExams(Request $request, $id){
        $formField = [];
        if ($request->has('imageUpload') && $request->imageUpload !== '') {
            $image = Image::make($request->imageUpload);
            $compressedImage = $image->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('jpg', 80)->encode('data-url');

            $formField['examImage'] = $compressedImage->encoded;
        }         

        $formField['exam'] = $request->examType;
        $formField['position'] = $request->position;


        $res = exam::where('id', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }

    public function deleteExams($id){
        $res = exam::where('id', $id)->delete();
        return $this->success([
            'message' => "Exams deleted Successfully"
        ]);
    }
}
