<?php

namespace App\Http\Controllers;

use App\Http\Responses\Response;

use App\services\Order_cachServices;
use Illuminate\Http\Request;
use Throwable;

class OrderCachController extends Controller
{
    private Order_cachServices $order_cach;
    public function __construct(Order_cachServices $order_cache){
        $this->order_cach=$order_cache;

    }
    public function get_all_order(){
$data=[];
try{

$data=$this->order_cach->get_all_orders();
return Response::Succes($data['order'],$data['message'],$data['code']);

}
catch(Throwable $th){
    $message=$this->$th->getMessage();
    $code=403;
    return Response::Err($data["order"],$message,$code);


}

    }
    public function create_order_cach($value){
$data=[];
try{
$data=$this->order_cach->Create_new_order_cach($value);
return Response::Succes($data["order"],$data["message"],$data["code"]);

}
catch(Throwable $th){
$message=$this->$th->getMessage();
$code=403;
return Response::Err($data,$message,$code);

}

    }


    public function accept_ordera($ide){

        $data=[];
        try{
            $data=$this->order_cach->accept_order($ide);
            return Response::Succes($data["data"],$data["message"],$data["code"]);


        }
        catch(Throwable $th){

            $message=$this->$th->getMessage();
            $code=403;
            return Response::Err($data,$message,$code);
        }
    }
}
