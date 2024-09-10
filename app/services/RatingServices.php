<?php
namespace App\services;

use App\Models\Course;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Empty_;

use function PHPUnit\Framework\isNull;

class RatingServices{

public function add_rating($request):array
{
//if(Auth::user()->hasRole("client")||Auth::user()->hasRole("tetcher")){
    $user=User::find(Auth::id());
    $status=$user->status;
    if($status=="enable")
    {
        $rate=Rating::where("user_id",Auth::id())->where("course_id",$request["course_id"])->get();
        if($rate->isEmpty()){



    $rating=Rating::create([
        "course_id"=>$request["course_id"],
        "value"=>$request["value"],
        "user_id"=>Auth::id(),

    ]);

    $message="Add rating successfly";
    $code=201;
    return ["rating"=>$rating,"message"=>$message,"code"=>$code];

}
else{

    return ["rating"=>[],"message"=>"لا يمكنك تقيم الكور اكثر من مرة ","code"=>403];


}
}
else{
    return ["rating"=>[],"message"=>"الحساب مقيد لا يمكنك اضافة تقيم لكورس","code"=>403];


}
/*
}
else{
    $message="forbedin";
    $code=403;
    return ["rating"=>[],"message"=>$message,"code"=>$code];


}

*/

}
public function get_rating():array
{
$id=1;
    $ratings = Rating::where('course_id', $id)->pluck('value')->toArray();
   $sum_of_rating= array_sum($ratings);
   return ["rating"=>$sum_of_rating,"message"=>"don","code"=>200];
}

}
