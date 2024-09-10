<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuesionRequest;
use App\Http\Responses\Response;
use App\Services\QuesionServices;
use Illuminate\Http\Request;
use Throwable;

class QuestionController extends Controller
{
    private QuesionServices $quesionServices;
    public function __construct(QuesionServices $quesionServices)
    {
        $this->quesionServices=$quesionServices;

    }

    public function create_quesion(QuesionRequest $quesionRequest)
    {
        $data=[];
        try{
            $data=$this->quesionServices->creat_quesion($quesionRequest);
            return Response::Succes($data["quesion"],$data["message"],$data["code"]);


        }
        catch(Throwable $th)
        {
            $message=$this->$th->getMessage();
            $code=500;
            return Response::Err($data,$message,$code);


        }
    }
}
