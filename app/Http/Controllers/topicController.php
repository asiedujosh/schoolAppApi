<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\topics;

use Illuminate\Http\Request;

class topicController extends Controller
{
    //
      //
      use HttpResponses;
      //
      public function index(){
          $topic = topics::all();
          return $this->success([
              'data' => $topic
             ]);
      }

      public function searchTopic(Request $request) {
        // $keyword = $request->input('keyword');
        $results = topics::latest()->filter(request(['keyword']))->get();
        return $this->success([
            'data' => $results
           ]);
    }


      public function store(Request $request){
          $topic = new topics;
          $topic->topic = $request->topic;
          $res = $topic->save();
  
          if($res){
           return $this->success([
               'data' => $topic
              ]);
          }
      }

      public function updateTopic(Request $request, $id){
        $formField = [
            'topic' => $request->topic,
        ];


        $res = topics::where('id', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }

    public function deleteTopic($id){
        $res = topics::where('id', $id)->delete();
        return $this->success([
            'message' => "Topics deleted Successfully"
        ]);
    }
}
