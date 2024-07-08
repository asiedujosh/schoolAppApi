<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\notification;
use Illuminate\Http\Request;

class notificationController extends Controller
{
    //
    use HttpResponses;

    public function index(Request $request){
        $pageNo = $request->input('page');
        $perPage = $request->input('perPage');
        $notification = notification::orderBy('id', 'DESC')->paginate($perPage, ['*'], 'page', $pageNo);
        return $this->success([
            'data' => $notification,
            'pagination' => [
                'total' => $notification->total(),
                'current_page' => $notification->currentPage(),
                'last_page' => $notification->lastPage()
            ]
            ]);
    }


    public function store(Request $request){
        $notification = new notification;
        $notification->title = $request->title;
        $notification->message = $request->message;
        $res = $notification->save();

        if($res){
            return $this->success([
                'data' => $notification
            ]);
        }
    }

    public function updateNotification(Request $request, $id){
        $formField = [
            'title' => $request->title,
            'message' => $request->message
        ];

        $res = notification::where('id', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }

    public function deleteNotification($id){
        $res = notification::where('id', $id)->delete();
        return $this->success([
            'message' => "Message Deleted"
        ]);
    }
}
