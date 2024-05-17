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

      public function mobileIndex(){
        $year = year::all();
        return $this->success([
            'data' => $year
        ]);
    }

      public function index(Request $request){
          $pageNo = $request->input('page');
          $perPage = $request->input('perPage');
          $year = year::orderBy('id', 'DESC')->paginate($perPage, ['*'], 'page', $pageNo);
          return $this->success([
              'data' => $year,
              'pagination' => [
                'total' => $year->total(),
                'current_page' => $year->currentPage(),
                'last_page' => $year->lastPage()
            ]
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

      public function checkYearAvailability(Request $request) {
        $year = $request->input('year');
       
        if(isset($year) && $year !== "undefined" ){
  
         // Perform your logic based on these parameters
         $exists = year::where('year', $year)->exists();
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
