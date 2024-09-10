<?php
namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class Response{

public static function Succes($data,$message,$code=200):JsonResponse
{
return Response()->json([

"status"=>1,
"message"=>$message,
"data"=>$data,


],$code);

}

public static function Err($data,$message,$code=500):JsonResponse
{
return Response()->json([

"status"=>0,
"message"=>$message,
"data"=>$data,


],$code);

}


public static function Validation($data,$message,$code=422):JsonResponse
{
return Response()->json([

"status"=>0,
"message"=>$message,
"data"=>$data,


],$code);

}

}
