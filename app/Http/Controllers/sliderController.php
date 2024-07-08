<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\slider;
use Intervention\Image\Facades\Image;

use Illuminate\Http\Request;

class sliderController extends Controller
{
    //
    use HttpResponses;

    public function index(Request $request){
        $pageNo = $request->input('page');
        $perPage = $request->input('perPage');
        $sliders = slider::orderBy('id', 'DESC')->paginate($perPage, ['*'], 'page', $pageNo);
        return $this->success([
            'data' => $sliders,
            'pagination' => [
                'total' => $sliders->total(),
                'current_page' => $sliders->currentPage(),
                'last_page' => $sliders->lastPage()  
            ]
        ]);
    }


    public function store(Request $request){
        $sliderImage = null;
        if ($request->has('imageUpload') && $request->imageUpload !== '') {
            $image = Image::make($request->imageUpload);
            $compressedImage = $image->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('jpg', 80)->encode('data-url');

            $sliderImage = $compressedImage->encoded;
        }   
        $sliders = new slider;
        $sliders->title = $request->title;
        $sliders->body = $request->body;
        $sliders->sliderImage = $sliderImage;
        $res = $sliders->save();

        if($res){
         return $this->success([
             'data' => $sliders
            ]);
        }
    }

    public function updateSlider(Request $request, $id){
        $formField = [];

        if($request->has('imageUpload') && request->imageUpload !== null){
            $image = Image::make($request->imageUpload);
            $compressedImage = $image->resize(500, null, function ($constraint){
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('jpg', 80)->encode('data-url');

            $formField['sliderImage'] = $compressedImage->encoded;
        } else {
            $formField['sliderImage'] = null;
        }

        $formField['title'] = $request->title;
        $formField['body'] = $request->body;
        $res = slider::where('id', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }


    public function deleteSlider($id){
        $res = slider::where('id', $id)->delete();
        if($res){
            return $this->success([
                'data' => "Delete Slider" 
            ]);
        }
    }
}
