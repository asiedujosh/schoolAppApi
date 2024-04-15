<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\news;

use Illuminate\Http\Request;

class newsController extends Controller
{
    use HttpResponses;
    //
    public function index(){
        $news = news::all();
        return $this->success([
            'data' => $news
           ]);
    }

    public function addNews(Request $request){
        $news = new news;
        $news->title = $request->title;
        $news->news = $request->news;
        $res = $news->save();
        if($res){
            return $this->success([
                'data' => $res
                ]);
        }
    }

    public function updateNews(Request $request, $id){
        $formField = [
            'title' => $request->title,
            'news' => $request->news
        ];

        $res = news::where('id', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }

    public function deleteNews($id){
        $res = news::where('id', $id)->delete();
        return $this->success([
            'message' => "Package deleted Successfully"
        ]);
    }


}
