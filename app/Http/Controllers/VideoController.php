<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoRequest;
use App\Http\Responses\Response;
use App\services\VideoService;
use Illuminate\Http\Request;
use Throwable;

class VideoController extends Controller
{
    private VideoService $videoService;
    public function __construct(VideoService $videoService){

        $this->videoService=$videoService;

    }
    public function create_video(VideoRequest $videoRequest){
        $data=[];
        try{

            $data=$this->videoService->creat_videos($videoRequest);
            return Response::Succes($data["video"],$data["message"],$data["code"]);

        }
        catch(Throwable $th)
        {

            $message=$this->$th->getMessage();
            $code=500;
            return Response::Err($data,$message,$code);
        }


    }
    public function get_video_by_ide($id){


        $data=[];
        try{

            $data=$this->videoService->get_video_by_id($id);
            return Response::Succes($data["video"],$data["message"],$data["code"]);

        }
        catch(Throwable $th)
        {

            $message=$this->$th->getMessage();
            $code=500;
            return Response::Err($data,$message,$code);
        }


    }
}
