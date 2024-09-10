<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestRequest;
use App\Http\Responses\Response;
use App\services\TestServices;
use Illuminate\Http\Request;
use Throwable;

class TestController extends Controller
{
    private TestServices $testServices;
    public function __construct(TestServices $testServices)
    {
$this->testServices=$testServices;


    }
    public function create_test(TestRequest $testRequest){
        $data=[];
            try{

                $data=$this->testServices->create_test($testRequest);
                return Response::Succes($data["test"],$data["message"],$data["code"]);

            }
            catch(Throwable $th)
            {

                $message=$this->$th->getMessage();
                $code=500;
                return Response::Err($data,$message,$code);
            }

    }
    public function get_test_courst($id){

        $data=[];
        try{

            $data=$this->testServices->get_test_of_cours($id);
            return Response::Succes($data["test"],$data["message"],$data["code"]);
        }


        catch(Throwable $th){
$message=$this->$th->getMessage();
$code=500;
return Response::Err($data,$message,$code);

        }
    }




    public function get_test_video($id){

        $data=[];
        try{

            $data=$this->testServices->get_test_of_video($id);
            return Response::Succes($data["test"],$data["message"],$data["code"]);
        }


        catch(Throwable $th){
$message=$this->$th->getMessage();
$code=500;
return Response::Err($data,$message,$code);

        }
    }

}
