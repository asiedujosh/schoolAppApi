<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\priviledges;
use Illuminate\Http\Request;

class priviledgeController extends Controller
{
    use HttpResponses;
    //
    public function index(Request $request){
        $pageNo = $request->input('page');
        $perPage = $request->input('perPage');
        $priviledge = priviledges::paginate($perPage, ['*'], 'page', $pageNo);
        return $this->success([
            'data' => $priviledge,
            'pagination' => [
                'total' => $priviledge->total(),
                'current_page' => $priviledge->currentPage(),
                'last_page' => $priviledge->lastPage()  
            ]
        ]);
    }

    public function mobileIndex(){
        $res = priviledges::all();
        return $this->success([
            'data' => $res
           ]); 
    }


    public function searchPriviledge(Request $request) {
        // $keyword = $request->input('keyword');
        $results = priviledges::latest()->filter(request(['keyword']))->get();
        return $this->success([
            'data' => $results
           ]);
    }

   

    public function store(Request $request){
        $priviledge = new priviledges;
        $priviledge->username = $request->username;
        $res = $priviledge->save();

        if($res){
         return $this->success([
             'data' => $priviledge
            ]);
        }
    }

    public function updatePriviledge(Request $request, $id){
        $formField['username'] = $request->username;
        $res = priviledges::where('id', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }

    public function deletePriviledge($id){
        $res = priviledges::where('id', $id)->delete();
        if($res){
        return $this->success([
            'message' => "Priviledge deleted Successfully"
        ]);
        }
    }
}
