<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Http\Responses\Response;
use App\Models\Section;
use App\services\SectionServices;
use Illuminate\Http\Request;
use Throwable;

class SectionController extends Controller

{
    private SectionServices $section;
    public function  __construct(SectionServices $sectionServices){
        $this->section=$sectionServices;


    }
    public function index(){
        $data=[];
        try{
            $data=$this->section->index();
            return Response::Succes($data["sections"],$data["message"],$data["code"]);

        }
        catch(Throwable $th){
            $message=$this->$th->getMessage();
            $code=500;
            return Response::Err($data,$message,$code);


        }

    }

    public function Create_Section(SectionRequest $sectionRequest)
    {
$data=[];
try{

    $data=$this->section->Creat_section($sectionRequest);
    return Response::Succes($data["section"],$data["message"],$data["code"]);
}
catch(Throwable $th){
$message=$this->$th->getMessage();
$code=500;
return Response::Err($data,$message,$code);

}


    }
    public function update_section(SectionRequest $sectionRequest,$id){

    $data=[];
try{

    $data=$this->section->Updat_section($sectionRequest,$id);
    return Response::Succes($data["section"],$data["message"],$data["code"]);

}
    catch(Throwable $th){

    $message=$this->$th->getMessage();
    $code=500;
        return Response::Err([],$message,$code);
}


    }
    public function delete_section($id)
    {
$data=[];
try{
    $data=$this->section->delete_section($id);
    return Response::Succes($data["section"],$data["message"],$data["code"]);
}catch(Throwable $th){

    $message=$this->$th->getMessage();
    $code=500;
    return Response::Err($data,$message,$code);
}

    }

    public function get_section_by_id($id){

        $data=[];
        try{

            $data=$this->section->get_section_by_id($id);
            return Response::Succes($data["data"],$data["message"],$data["code"]);
        }
        catch(Throwable $th)
        {
            $message=$this->$th->getMessage();
            $code=500;
            return Response::Err($data,$message,$code);

        }
    }
}
