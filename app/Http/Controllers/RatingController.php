<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use App\Http\Responses\Response;
use App\services\RatingServices;
use Illuminate\Http\Request;
use Throwable;

class RatingController extends Controller
{
    private RatingServices $RatingServices;
    public function __construct(RatingServices $ratingServices){
        $this->RatingServices=$ratingServices;
    }
    public function add_rating(RatingRequest $ratingRequest)
    {

        $data=[];
        try{

            $data=$this->RatingServices->add_rating($ratingRequest);
            return Response::Succes($data["rating"],$data["message"],$data["code"]);
        }
        catch(Throwable $th){
            $message=$this->$th->getMessage();
            $code=500;
            return Response::Err([],$message,$code);

        }
    }

    public function get_rating(){
        $data=[];
        try{
            $data=$this->RatingServices->get_rating();
            return Response::Succes($data["rating"],$data["message"],$data['code']);


        }
        catch(Throwable $th){

            $message=$this->$th->getMessage();
            $code=500;
            return Response::Err($data,$message,$code);
        }

    }
}
