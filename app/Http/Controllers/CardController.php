<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardRequest;
use App\Http\Responses\Response;
use App\services\CardServices;
use Illuminate\Http\Request;
use Throwable;

class CardController extends Controller
{
    private CardServices $cardServices;
    public function __construct(CardServices $cardServices){

        $this->cardServices=$cardServices;
    }
    public function Create_card(CardRequest $cardRequest)
    {
$data=[];
try{

    $data=$this->cardServices->Create_cards($cardRequest);
    return Response::Succes($data["cards"],$data["message"],$data["code"]);

}catch(Throwable $th){

    $message=$this->$th->getMessage();
    $code=500;
    return Response::Err($data,$message,$code);
}

    }
    public function get_all_cardss(){
        $data=[];
        try{
            $data=$this->cardServices->get_all_cards();
            return Response::Succes($data["data"],$data["message"],$data["code"]);


        }
        catch(Throwable $th){
            $message=$this->$th->getMessage();
            $code=403;
            return Response::Err($data,$message,$code);

        }
    }
}
