<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\aboutModel;
use App\Models\bannerTypeModel;
use App\Models\contactModel;
use App\Models\heroBannerModel;
use App\Models\privacyModel;
use App\Models\productsModel;
use App\Models\teamModel;
use App\Models\testimonialModel;
use App\Models\tncModel;

use Illuminate\Http\Request;

class pagesController extends Controller
{
    use HttpResponses;
    //

    //Get
    public function getAbout(){
        $about = aboutModel::all();
        return $this->success([
            'data' => $about
           ]);
        }

    
    public function getTeam(){
        $team = teamModel::all();
        return $this->success([
             'data' => $team
            ]);
        }

    public function getTNC(){
        $tnc = tncModel::all();
        return $this->success([
            'data' => $tnc
           ]); 
    }

    public function getContact(){
        $contact = contactModel::all();
        return $this->success([
            'data' => $contact
           ]); 
    }

    public function getTestimonial(){
        $testimonial = testimonialModel::all();
        return $this->success([
            'data' => $testimonial
           ]); 
    }

    public function getHeroBanner(){
        $heroBanner = heroBannerModel::all();
        return $this->success([
            'data' => $heroBanner
           ]); 
    }

    public function getProducts(){
        $product = productsModel::all();
        return $this->success([
            'data' => $product
           ]); 
    }

    public function getBannerType(){
        $bannerType = bannerTypeModel::all();
        return $this->success([
            'data' => $bannerType
           ]); 
    }


    //Add
    public function addAbout(Request $request){
        $about = new aboutModel;
        $about->about = $request->about;
        $res = $about->save();

        if($res){
            return $this->success([
                'data' => $about
            ]);
        }
    }

    public function addTeam(Request $request){
        $team = new teamModel;
        $team->team = $request->team;
        $res = $team->save();

        if($res){
            return $this->success([
                'data' => $team
            ]);
        }
    }

    public function addTnc(Request $request){
        $tnc = new tncModel;
        $tnc->tnc = $request->tnc;
        $res = $tnc->save();

        if($res){
            return $this->success([
                'data' => $tnc
            ]);
        }
    }

    public function addContact(Request $request){
        $contact = new contactModel;
        $contact->email = $request->email;
        $contact->address = $request->address;
        $contact->phoneNo = $request->phoneNo;
        $res = $contact->save();

        if($res){
            return $this->success([
                'data' => $contact
            ]);
        }
    }


    public function addTestimonial(Request $request){
        $testimonial = new testimonialModel;
        $testimonial->name = $request->name;
        $testimonial->testimony = $request->testimony;
        $res = $testimonial->save();

        if($res){
            return $this->success([
                'data' => $testimonial
            ]);
        }
    }


    public function addHeroBanner(Request $request){
        $heroBanner = new heroBannerModel;
        $heroBanner->title = $request->title;
        $heroBanner->body = $request->body;
        $res = $heroBanner->save();

        if($res){
            return $this->success([
                'data' => $heroBanner
            ]);
        }
    }


    public function addProducts(Request $request){
        $product = new productsModel;
        $product->productImage = $request->imageUpload;
        $product->title = $request->title;
        $product->description = $request->description;
        $res = $product->save();

        if($res){
            return $this->success([
                'data' => $product
            ]);
        }
    }


    public function addBannerType(Request $request){
        $bannerType = new bannerTypeModel;
        $banner->type = $request->type;
        $res = $banner->save();

        if($res){
            return $this->success([
                'data' => $bannerType
            ]);
        }
    }


    //Update
    public function updateAbout(Request $request, $id){
        $formField['about'] = $request->about;
        $res = aboutModel::where('id', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }


    public function updateTeam(Request $request, $id){
        $formField['team'] = $request->team;
        $res = teamModel::where('id', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }


    public function updateTnc(Request $request, $id){
        $formField['tnc'] = $request->tnc;
        $res = tncModel::where('id', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }


    public function updateContact(Request $request, $id){
        $formField = [
            'email' => $request->email,
            'address' => $request->address,
            'phoneNo' => $request->phoneNo,
        ];

        $res = contactModel::where('id', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }


    public function updateTestimonial(Request $request, $id){
        $formField = [
            'name' => $request->name,
            'testimony' => $request->testimony
        ];
        $res = testimonialModel::where('id', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }


    public function updateHeroBanner(Request $request, $id){
        $formField = [
            'title' => $request->title,
            'body' => $request->body
        ];
        $res = heroBannerModel::where('id', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }


    public function updateProducts(Request $request, $id){
        $formField = [
            'productImage' => $request->imageUpload,
            'title' => $request->title,
            'description' => $request->description
        ];
        $res = productsModel::where('id', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }


    public function updateBannerType(Request $request, $id){
        $formField = [
            'type' => $request->type
        ];
        $res = bannerTypeModel::where('id', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }


    //Delete
    public function deleteAbout($id){
        $res = aboutModel::where('id', $id)->delete();
        return $this->success([
            'data' => "About deleted Successfully"
        ]);
    }


    public function deleteTeam($id){
        $res = teamModel::where('id', $id)->delete();
        return $this->success([
            'data' => "Team deleted Successfully"
        ]);
    }


    public function deleteTnc($id){
        $res = tncModel::where('id', $id)->delete();
        return $this->success([
            'data' => "TNC deleted Successfully"
        ]);
    }


    public function deleteContact($id){
        $res = contactModel::where('id', $id)->delete();
        return $this->success([
            'data' => "Contact deleted Successfully"
        ]);
    }


    public function deleteTestimonial($id){
        $res = testimonialModel::where('id', $id)->delete();
        return $this->success([
            'data' => "Testimonial deleted Successfully"
        ]);
    }


    public function deleteHeroBanner($id){
        $res = heroBannerModel::where('id', $id)->delete();
        return $this->success([
            'data' => "Hero Banner deleted Successfully"
        ]);
    }


    public function deleteProducts($id){
        $res = productsModel::where('id', $id)->delete();
        return $this->success([
            'data' => "Product Card deleted Successfully"
        ]);
    }





}
