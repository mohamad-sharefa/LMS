<?php

namespace App\Http\Controllers;

use App\Http\Requests\ViewRequest;
use App\Http\Responses\Response;
use App\services\ViewService;

use Illuminate\Http\Request;
use Throwable;

class ViewController extends Controller
{
    private ViewService $viewServices;
    public function __construct(ViewService $viewServices){

        $this->viewServices=$viewServices;
    }
    public function create_view(ViewRequest $viewRequest){

        $data=[];
        try{

            $data=$this->viewServices->create_view($viewRequest);
            return Response::Succes($data["view"],$data["message"],$data["code"]);

        }

        catch(Throwable $th){

            $message=$this->$th->getMessage();
            $code=500;
            return Response::Err($data,$message,$code);
        }
    }

    public function get_view($id){

        $data=[];
        try{

            $data=$this->viewServices->get_views($id);
            return Response::Succes($data["data"],$data["message"],$data["code"]);
        }
        catch(Throwable $th){

            $message=$this->$th->getMessage();
            $code=403;
            return Response::Err($data,$message,$code);
        }
    }
}
