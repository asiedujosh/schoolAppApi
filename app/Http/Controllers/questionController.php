<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\question;
use App\Services\ImageCompressor;
use Intervention\Image\Facades\Image;

use Illuminate\Http\Request;

class questionController extends Controller
{
    use HttpResponses;
      //
    public function index(Request $request){
      $pageNo = $request->input('page');
      $perPage = $request->input('perPage');
      $question = question::orderBy('questionNo', 'DESC')->paginate($perPage, ['*'], 'page', $pageNo);
          return $this->success([
              'data' => $question,
              'pagination' => [
                'total' => $question->total(),
                'current_page' => $question->currentPage(),
                'last_page' => $question->lastPage()
              ]
             ]);
      }

    public function searchQuestion(Request $request) {
      $examType = $request->input('examType');
      $year = $request->input('year');
      $subject = $request->input('subject');

       // Perform your logic based on these parameters
       $query = question::where('examId', $examType)->where('yearId', $year)->where('subjectId', $subject);
       $results = $query->orderBy('questionNo', 'asc')->get();
        // $results = question::latest()->filter(request(['keyword']))->get();
        return $this->success([
            'data' => $results
           ]);
    }

    public function countQuestions(){
      $countQuestions = question::count();
      return $this->success([
        'data' => $countQuestions
      ]);
    }

    public function selectedQuestions(Request $request){
        $examType = $request->input('examType');
        $year = $request->input('year');
        $subject = $request->input('subject');
        $questionNos = $request->input('questionNos');

        // Perform your logic based on these parameters
        $query = question::where('examId', $examType)->where('yearId', $year)->where('subjectId', $subject);
        $questions = $query->orderBy('questionNo', 'asc')->get();

        if ($questionNos !== null) {
            $query->take($questionNos);
        }

        $questions = $query->get();

        if($questions){ 
            return $this->success([
                'data' => $questions
               ]);
        } else {
            return 'No data';
        }
    }

  
    public function store(Request $request){
          $question = new question;
          $question->examId = $request->examType;
          $question->yearId = $request->year;
          $question->subjectId = $request->subject;
          $question->topicId = $request->topic;
          $question->questionNo = $request->questionNo;
          $question->question = $request->question;
          $question->questionEquation = $request->questionEquation;
          $question->answer = $request->answer;
          $question->optionsWithEquation = $request->optionsWithEquation;
          $question->hints = $request->hints;
          $question->publisher = $request->publisher;
          
          if (!empty($request->imageOptions)) {
            $question->options = null;
            $base64Images = $request->imageOptions;
            //   return $base64Image;
            $resultArray = [];
            // Compress each image
            foreach($base64Images as $base64Image){
              $image = Image::make($base64Image);
              $compressedImage = $image->resize(200, null, function ($constraint) {
                  $constraint->aspectRatio();
                  $constraint->upsize();
              })->encode('jpg', 80)->encode('data-url');
              $resultArray[] = $compressedImage->encoded;
              // Return the base64-encoded compressed image
              // return response()->json(['compressed_image' => $compressedImage->encoded]);
            }
              $joinedImages = implode('**', $resultArray);
              $question->imageOptions = $joinedImages;
          } else {
            $question->options = $request->answerOptions;
            $question->imageOptions = null;
          }

          $res = $question->save();
  
          if($res){
           return $this->success([
               'data' => $question
              ]);
          }
      }

      public function updateQuestion(Request $request, $id){
        $formField = [
            'examId' => $request->examType,
            'yearId' => $request->year,
            'subjectId' => $request->subject,
            'topicId' => $request->topic,
            'questionNo' => $request->questionNo,
            'question' => $request->question,
            'questionEquation' => $request->questionEquation,
            'optionsWithEquation' => $request->optionsWithEquation,
            'answer' => $request->answer,
            'hints' => $request->hints
        ];

        if (!empty($request->imageOptions)) {
            $base64Images = $request->imageOptions;
            //   return $base64Image;
            if (is_array($request->imageOptions)) {
            $resultArray = [];
            // Compress each image
            foreach($base64Images as $base64Image){
              $image = Image::make($base64Image);
              $compressedImage = $image->resize(200, null, function ($constraint) {
                  $constraint->aspectRatio();
                  $constraint->upsize();
              })->encode('jpg', 80)->encode('data-url');
              $resultArray[] = $compressedImage->encoded;
              // Return the base64-encoded compressed image
              // return response()->json(['compressed_image' => $compressedImage->encoded]);
            }
              $joinedImages = implode('**', $resultArray);
              $formField['imageOptions'] = $joinedImages;
          } else {
            $formField['imageOptions'] = $request->imageOptions;
          }
        }
          
          else {
            $formField['options'] = $request->answerOptions;
            $formField['imageOptions'] = null;
          }


        $res = question::where('id', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }

    public function deleteQuestion($id){
        $res = question::where('id', $id)->delete();
        return $this->success([
            'message' => "Question deleted Successfully"
        ]);
    }
      
}
