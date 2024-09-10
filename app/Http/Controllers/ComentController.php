<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComentRequest;
use App\Http\Responses\Response;
use App\services\ComentService;
use App\services\ComentServices;
use Illuminate\Http\Request;
use Throwable;

class ComentController extends Controller
{
    private ComentServices $comentservices;
    public function __construct(ComentServices $comentService){
$this->comentservices=$comentService;


    }
    public function creat_comment(ComentRequest $comentRequest)
    {
    $data=[];
    try{
$data=$this->comentservices->create_comment($comentRequest);
return Response::Succes($data["comment"],$data["message"],$data['code']);


    }
    catch(Throwable $th){
$message=$this->$th->getMessage();
$code=500;
return Response::Err([],$message,$code);

    }

    }
    public function delet_comment($id){

        $data=[];
        try{
            $data=$this->comentservices->delet_comment($id);
            return Response::Succes($data["coment"],$data["message"],$data["code"]);



        }
        catch(Throwable $th){

            $message=$this->$th->getMessage();
            $code=500;
            return Response::Err($data,$message,$code);
        }
    }
}
