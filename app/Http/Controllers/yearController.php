<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\year;

use Illuminate\Http\Request;

class yearController extends Controller
{
      //
      use HttpResponses;
      //
      public function index(){
          $year = year::all();
          return $this->success([
              'data' => $year
             ]);
      }

      public function searchYear(Request $request) {
        // $keyword = $request->input('keyword');
        $results = year::latest()->filter(request(['keyword']))->get();
        return $this->success([
            'data' => $results
           ]);
    }
  
      public function store(Request $request){
          $year = new year;
          $year->year = $request->examsYear;
          $res = $year->save();
  
          if($res){
           return $this->success([
               'data' => $year
              ]);
          }
      }

      public function updateYear(Request $request, $id){
        $formField = [
            'year' => $request->examsYear,
        ];


        $res = year::where('id', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }

    public function deleteYear($id){
        $res = year::where('id', $id)->delete();
        return $this->success([
            'message' => "Exams deleted Successfully"
        ]);
    }


}
