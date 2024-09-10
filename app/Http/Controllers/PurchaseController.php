<?php

namespace App\Http\Controllers;

use App\Http\Responses\Response;
use App\services\PurchasServeices;
use Illuminate\Http\Request;
use Throwable;

class PurchaseController extends Controller
{
    private PurchasServeices $purchasServeices;
    public function __construct(PurchasServeices $purchasServeices){

        $this->purchasServeices=$purchasServeices;

    }
    public function buy_cours($id){

        $data=[];
        try{

            $data=$this->purchasServeices->buy_course($id);
            return Response::Succes($data["cours"],$data["message"],$data["code"]);
        }
        catch(Throwable $th){
$message=$this->$th->getMessage();
$code=500;
return Response::Err($data,$message,$code);


        }
    }

    public function get_my_cours_buy(){

        $data=[];
        try{
            $data=$this->purchasServeices->get_my_cours_buy();
            return Response::Succes($data["data"],$data["message"],$data["code"]);




        }
        catch(Throwable $th){

            $message=$this->$th->getMessage();
            $code=500;
            return Response::Err($data,$message,$code);
        }
    }
}
