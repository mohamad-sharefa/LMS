<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Responses\Response;
use App\Models\User;
use App\services\UserServices;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



use Throwable;

class UserController extends Controller
{

    private UserServices $userServicess;
    public function __construct(UserServices $userServices){
$this->userServicess=$userServices;

    }
    public function index(){

            $users=User::get();
            return response()->json([
                "data"=>$users

                ],200);




    }
    public function get_user_type($type){
        $data=[];
        try{

            $data=$this->userServicess->get_user_type($type);


                return Response::Succes($data["users"],$data["message"],$data["code"]);


           // $message="All user of ".$type;
        }
        catch(Throwable $th ){
        $message=$this->$th->getMessage();
        $code=401;
        return Response::Err("no data",$message,$code);

        }


    }
    public function Register(UserRequest $request)
    {

$data=[];
try{

$data=$this->userServicess->Register($request);
return Response::Succes($data["user"],$data["message"]);

}
catch(Throwable $th){

    $message=$th->getMessage();
    return Response::Err($data,$message);
}





}





public function Delete_My_Account(){

    $id=0;
    if(Auth::id()){
        $id=Auth::id();

    }
    //dd($id);
    if($id){
        $user=User::find($id);
    }




    if($user){
        $usera=Auth::guard('sanctum')->user();
        $usera->currentAccessToken()->delete();


        $user->delete();
        return response()->json([
            "message"=>"deleted don",
            "user"=>$user,
            "id"=>$id

        ],200);
    }
    else{
        return response()->json([
            "message"=>"this token not found"
        ],401);
    }


}





public function Token_not_found(){
    return response()->json(["message"=>"invalid token"],401);
}
public function Login(Request $request)
{
try{

    $user=$this->userServicess->Login($request);
    return ["message"=>$user["message"],"user"=>$user["user"],"code"=>$user["code"]];
}
catch(Throwable $th){

    $message=$this->$th->getMessage();
    return ["message"=>$message];
}
}
public function Logout()
{
try{

$user=$this->userServicess->Logout();
return response()->json([
//"user"=>$user["user"],
"message"=>$user["message"],


],$user["code"]);

}
catch(Throwable $th){

    $message=$this->$th->getMessage();
    return response()->json([
    "message"=>$message

    ]);
}

}
public function Charge_my_account(Request $request){

    $data=[];
    try{

        $data=$this->userServicess->Charge_my_account($request);
        return Response::Succes($data["card"],$data["message"],$data["code"]);

    }
    catch(Throwable $th){

        $message=$this->$th->getMessage();
        $code=500;
        return Response::Err($data,$message,$code);
    }

}
public function updet_my_info(Request $request)
{


    $data=[];
    try{

        $data=$this->userServicess->chang_my_info($request);
        return Response::Succes($data["user"],$data["message"],$data["code"]);

    }
    catch(Throwable $th)
    {

        $message=$this->$th->getMessage();
        $code=500;
        return Response::Err($data,$message,$code);

    }
}
public function get_my_info(){


    $data=[];
    try{

        $data=$this->userServicess->get_my_info();
        return Response::Succes($data["user"],$data["message"],$data["code"]);

    }
    catch(Throwable $th){

        $message=$this->$th->getMessage();
        $code=500;
        return Response::Err($data,$message,$code);

    }
}
public function get_details_account($id){

    $data=[];
    try{

        $data=$this->userServicess->get_detels_account($id);
        return Response::Succes($data["user"],$data["message"],$data["code"]);
    }
    catch(Throwable $th){

        $message=$this->$th->getMessage();
        $code=500;
        return Response::Err($data,$message,$code);

    }
}
public function get_users_of_6_month(){

    $data=[];
    try{

        $data=$this->userServicess->get_users_of_6_month();
        return Response::Succes($data["users"],$data["message"],$data["code"]);

    }
    catch(Throwable $th){

        $message=$this->$th->getMessage();
        $code=500;
        return Response::Err($data,$message,$code);
    }
}

public function enable_account($id){
    $data=[];
    try{

        $data=$this->userServicess->enable_account($id);
        return Response::Succes($data["user"],$data["message"],$data["code"]);

    }
    catch(Throwable $th){

        $message=$this->$th->getMessage();
        $code=500;
        return Response::Err($data,$message,$code);
    }
}



public function desable_account($id){
    $data=[];
    try{

        $data=$this->userServicess->desable_account($id);
        return Response::Succes($data["user"],$data["message"],$data["code"]);

    }
    catch(Throwable $th){

        $message=$this->$th->getMessage();
        $code=500;
        return Response::Err($data,$message,$code);
    }
}


}
