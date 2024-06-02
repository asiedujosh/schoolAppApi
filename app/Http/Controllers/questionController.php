<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\question;
use App\Models\oralQuestionModel;
use App\Services\ImageCompressor;
use Illuminate\Support\Facades\Storage;
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


    public function getOralQuestions(Request $request){
      
        $pageNo = $request->input('page');
        $perPage = $request->input('perPage');
        // Fetch all oral questions from the database
        $oralQuestions = OralQuestionModel::orderBy('questionNo', 'DESC')->paginate($perPage, ['*'], 'page', $pageNo);

        // Generate pre-signed URLs for each audio file
        foreach ($oralQuestions as $question) {
            $question->audio_url = Storage::disk('s3')->temporaryUrl(
                $question->question, now()->addMinutes(5)
            );
        }

        return $this->success([
          'data' => $oralQuestions,
          'pagination' => [
            'total' => $oralQuestions->total(),
            'current_page' => $oralQuestions->currentPage(),
            'last_page' => $oralQuestions->lastPage()
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


    public function searchOralQuestion(Request $request){
      $examType = $request->input('examType');
      $year = $request->input('year');
      $subject = $request->input('subject');

       // Perform your logic based on these parameters
       $query =  OralQuestionModel::where('examId', $examType)->where('yearId', $year)->where('subjectId', $subject);
       $results = $query->orderBy('questionNo', 'asc')->get();

         // Generate pre-signed URLs for each audio file
         foreach ($results  as $result) {
          $result->audio_url = Storage::disk('s3')->temporaryUrl(
            $result->question, now()->addMinutes(5)
          );
        }

        return $this->success([
          'data' => $results
         ]);
    }


    public function checkQuestionNo(Request $request) {
      $examType = $request->input('examType');
      $year = $request->input('year');
      $subject = $request->input('subject');
      $questionNo = $request->input('questionNo');

      if(isset($questionNo) && $questionNo !== "undefined" ){

       // Perform your logic based on these parameters
       $exists = question::where('examId', $examType)->where('yearId', $year)->where('subjectId', $subject)->where('questionNo', $questionNo)->exists();
        // $results = question::latest()->filter(request(['keyword']))->get();
       return $this->success([
        'data' => $exists
      ]);

    } else {
      return $this->success([
        'data' => true
      ]);
    }
    }


    public function checkOralQuestionNo(Request $request) {
      $examType = $request->input('examType');
      $year = $request->input('year');
      $subject = $request->input('subject');
      $questionNo = $request->input('questionNo');

      if(isset($questionNo) && $questionNo !== "undefined" ){

       // Perform your logic based on these parameters
       $exists = OralQuestionModel::where('examId', $examType)->where('yearId', $year)->where('subjectId', $subject)->where('questionNo', $questionNo)->exists();
        // $results = question::latest()->filter(request(['keyword']))->get();
       return $this->success([
        'data' => $exists
      ]);

    } else {
      return $this->success([
        'data' => true
      ]);
    }
    }


    public function countQuestions(){
      $countQuestions = question::count();
      return $this->success([
        'data' => $countQuestions
      ]);
    }

    public function countOralQuestions(){
      $countOralQuestions = OralQuestionModel::count();
      return $this->success([
        'data' => $countOralQuestions
      ]);
    }

    // This is for actual quiz
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

    // This is for oral quiz
    public function selectedOralQuestions(Request $request){
      $examType = $request->input('examType');
      $year = $request->input('year');
      $subject = $request->input('subject');
      $questionNos = $request->input('questionNos');

      //Perform your logic based on these parameters
      $query = oralQuestionModel::where('examId', $examType) -> where('yearId', $year)->where('subjectId', $subject);
      $oralQuestions = $query->orderBy('questionNo', 'asc')->get();

      if($questionNos !== null){
        $query->take($questionNos);
      }

      $oralQuestions = $query->get();

       // Generate pre-signed URLs for each audio file
       foreach ($oralQuestions as $question) {
        $question->audio_url = Storage::disk('s3')->temporaryUrl(
            $question->question, now()->addMinutes(5)
        );
    }

      if($oralQuestions){
          return $this->success([
            'data' => $oralQuestions
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

      public function storeOralQuestion(Request $request){
      try {
          // Generate a unique filename with timestamp
          $filename = time() . '_' . $request->file('question')->getClientOriginalName();
  
          // Store the file in the S3 bucket
          $path = Storage::disk('s3')->put('', $request->file('question'), $filename, 'public');

         
  
          if ($path) {
              // File uploaded successfully
              $questionMimeType = $request->file('question')->getClientMimeType();
  
              $oralQuestion = new OralQuestionModel;
              $oralQuestion->examId = $request->examType;
              $oralQuestion->yearId = $request->year;
              $oralQuestion->subjectId = $request->subject;
              $oralQuestion->topicId = $request->topic;
              $oralQuestion->questionNo = $request->questionNo;
              $oralQuestion->comment = $request->comment;
              $oralQuestion->question = $path;
              $oralQuestion->mimeType = $questionMimeType;
              $oralQuestion->answer = $request->answer;
              $oralQuestion->options = $request->answerOptions;
              $oralQuestion->hints = $request->hints;
              $oralQuestion->publisher = $request->publisher;
  
              $res = $oralQuestion->save();

              if($res){
                return $this->success([
                    'data' => $oralQuestion
                   ]);
               }
          } else {
              return response()->json([
                  'success' => false,
                  'message' => 'Failed to upload file to S3.',
              ], 500);
          }
      } catch (\Exception $e) {
          // Handle any exceptions here
          return response()->json([
              'success' => false,
              'message' => 'Failed to store oral question: ' . $e->getMessage(),
          ], 500);
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


    public function updateOralQuestion(Request $request){
      $id = $request->id;
      $examId = $request->examType;
      $yearId = $request->year;
      $subjectId = $request->subject;
      $topicId = $request->topic;
      $questionNo = $request->questionNo;
      $hints = $request->hints;
      $oldPath = $request->oldPath;
      $options = $request->answerOptions;
      $answer = $request->answer;
      $mimeType = $request->mimeType;

      if($request->file('question')){
        if (Storage::disk('s3')->exists($oldPath)) {
          
          // Generate a unique filename with timestamp
          $filename = time() . '_' . $request->file('question')->getClientOriginalName();
          // Store the file in the S3 bucket
          $path = Storage::disk('s3')->put('', $request->file('question'), $filename, 'public');
           if($path){
            Storage::disk('s3')->delete($oldPath);
            $questionMimeType = $request->file('question')->getClientMimeType();
            $formField = [
            'examId' => $examId,
            'yearId' => $yearId,
            'subjectId' => $subjectId,
            'topicId' => $topicId,
            'questionNo' => $questionNo,
            'question' => $path,
            'mimeType' =>  $questionMimeType,
            'options' => $options,
            'answer' => $answer,
            'hints' => $hints
            ];

            $res = OralQuestionModel::where('id', $id)->update($formField);
            if($res){
                return $this->success([
                'data' => $res
                ]);
            }
          }
        }
       }
       else {
        $formField = [
          'examId' => $examId,
          'yearId' => $yearId,
          'subjectId' => $subjectId,
          'topicId' => $topicId,
          'questionNo' => $questionNo,
          'options' => $options,
          'answer' => $answer,
          'hints' => $hints
          ];

          $res = OralQuestionModel::where('id', $id)->update($formField);
          if($res){
              return $this->success([
              'data' => $res
              ]);
          }
        }
      }
    

    public function deleteQuestion($id){
        $res = question::where('id', $id)->delete();
        return $this->success([
            'message' => "Question deleted Successfully"
        ]);
    }

    public function deleteOralQuestion(Request $request, $id){
      $oldPath = $request->oldPath;
      $id = $request->id;
      if (Storage::disk('s3')->exists($oldPath)) {
        Storage::disk('s3')->delete($oldPath);
        $res = OralQuestionModel::where('id', $id)->delete();
        return $this->success([
            'message' => "Question deleted Successfully"
        ]);
      }
    }
      
}
