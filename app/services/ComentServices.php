<?php
namespace App\services;

use App\Models\Coment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ComentServices{


    public function create_comment($request):array
    {
        $user=User::find(Auth::id());
$status=$user->status;
if($status=="enable")
{
    $comment=Coment::create([

    "value"=>$request["value"],
    "course_id"=>$request["course_id"]??0,
    "video_id"=>$request["video_id"]??0,
    "parentId"=>$request["parentId"]?? 0,
    "user_id"=>Auth::id(),
]);
$messag="created successflt";
$code=201;
return ["comment"=>$comment,"message"=>$messag,"code"=>$code];
}
else{
    return ["comment"=>[],"message"=>"الحساب مقيد لا يمكنك اضافة تعليق","code"=>403];


}
    }
    public function delet_comment($id):array
    {
        $user_id=Auth::id();


        $comment=Coment::where("id",$id)->where("user_id",$user_id)->first();
        if($comment){

               $comment->replies()->delete();







                // Delete the comment itself
                $comment->delete();
                $message="deleted successflu";
                $code=200;
                return ["coment"=>$comment,"message"=>$message,"code"=>$code];



        }

        $message="غير مسموح لك حذفه";
        $code=500;
        return ["coment"=>[],"message"=>$message,"code"=>$code];

    }
}
