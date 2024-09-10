<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Http\Responses\Response;
use App\services\CourseServices;
use Illuminate\Http\Request;
use Throwable;

class CourseController extends Controller
{
    private CourseServices $courseServices;
    public function __construct(CourseServices $courseServices){

        $this->courseServices=$courseServices;
    }
    public function index(){

        $data=[];
        try{

            $data=$this->courseServices->index();
            return Response::Succes($data["courses"],$data["message"],$data["code"]);
        }
        catch(Throwable $th){
            $message=$this->$th->getMessage();
            $code=500;
            return Response::Err([],$message,$code);

        }
    }


    public function search($request){

        $data=[];
        try{

            $data=$this->courseServices->search_course($request);
            return Response::Succes($data["courses"],$data["message"],$data["code"]);
        }
        catch(Throwable $th){
            $message=$this->$th->getMessage();
            $code=500;
            return Response::Err([],$message,$code);

        }
    }

    public function Create_cours(CourseRequest $courseRequest){

$data=[];
try{
    $data=$this->courseServices->create_course($courseRequest);
    return Response::Succes($data["courses"],$data["message"],$data["code"]);


}
catch(Throwable $th){

    $message=$this->$th->getMessage();
    $code=500;
    return Response::Err([],$message,$code);
}

    }
    public function get_my_courses(){

        $data=[];
        try{
            $data=$this->courseServices->get_my_course();
            return Response::Succes($data["courses"],$data["message"],$data["code"]);



        }
        catch(Throwable $th){

            $message=$this->$th->getMessage();
            $code=500;
            return Response::Err($data,$message,$code);
        }
    }


    public function get_courses_of_tetcher($id){

        $data=[];
        try{
            $data=$this->courseServices->get_cours_of_tetcher($id);
            return Response::Succes($data["courses"],$data["message"],$data["code"]);



        }
        catch(Throwable $th){

            $message=$this->$th->getMessage();
            $code=500;
            return Response::Err($data,$message,$code);
        }
    }
    public function delet_my_course($id)
    {
$data=[];
try{

$data=$this->courseServices->delet_my_course($id);
return Response::Succes($data["course"],$data["message"],$data["code"]);


}
catch(Throwable $th)
{

    $message=$this->$th->getMessage();
    $code=500;
    return Response::Err($data,$message,$code);
}

    }


    public function get_course_by_id($id)
    {

        $data=[];
        try{

            $data=$this->courseServices->get_cours_by_id($id);
            return Response::Succes($data["course"],$data["message"],$data["code"]);

        }
        catch(Throwable $th){

            $messag=$this->$th->getMessage();
            $code=500;
            return Response::Err($data,$messag,$code);
        }
    }
    public function enable_course($id){

        $data=[];
        try{

            $data=$this->courseServices->enable_course($id);
            return Response::Succes($data["course"],$data["message"],$data["code"]);
        }
        catch(Throwable $th){

            $message=$this->$th->getMessage();
            $code=500;
            return Response::Err($data,$message,$code);
        }
    }



    public function desable_course($id){

        $data=[];
        try{

            $data=$this->courseServices->desable_course($id);
            return Response::Succes($data["course"],$data["message"],$data["code"]);
        }
        catch(Throwable $th){

            $message=$this->$th->getMessage();
            $code=500;
            return Response::Err($data,$message,$code);
        }
    }
}
