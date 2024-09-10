<?php
namespace App\services;

use App\Models\Course;
use App\Models\Question;
use App\Models\Test;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TestServices{

public function create_test($request):array
{
//if(Auth::user()->hasRole("tetcher")){


    $user=User::find(Auth::id());
$status=$user->status;
if($status=="enable")
{

    $course=Course::find($request["course_id"]);
    $haveCourse=$course->user_id;
    if($haveCourse==Auth::id()||Auth::user()->hasRole("admin")){

    $test=Test::create([
        "name"=>$request["name"],
        "description"=>$request["description"],
        "user_id"=>Auth::id(),
        "course_id"=>$request["course_id"]??0,
        "video_id"=>$request["video_id"]??0



    ]);
    $message="تم انشاء اختبار جديد ";
    $code=201;
    return ["test"=>$test,"message"=>$message,"code"=>$code];
    }
    else{

        return ["test"=>[],"message"=>"أنت لا تملك هذه الصلاحية","code"=>403];
    }

}

else{
    return ["test"=>[],"message"=>"حسابك مقيد لا يمكنك عمل هذا الإجراء","code"=>403];


}
/*}


else{
    $message="غير مصرح لك عمل اختبار جديد";
    $code=403;
    return ["test"=>[],"message"=>$message,"code"=>$code];

}*/

}
public function get_test_of_cours ($id):array

{
    $user=User::find(Auth::id());
$status=$user->status;
if($status=="enable")
{
    $test_layout=Test::where("course_id",$id)->first();
    $quesion=Question::where("test_id",$test_layout->id)->get();
    $test=["test"=>$test_layout ,"quesion"=>$quesion];
    return ["test"=>$test,"message"=>"تم جلب الإختبار بنجاح" ,"code"=>200];
}
else{

    return ["test"=>[],"message"=>"حسابك مقيد لا يمكنك عمل هذا الإجراء" ,"code"=>403];

}

}



public function get_test_of_video ($id):array

{
    $user=User::find(Auth::id());
$status=$user->status;
if($status=="enable")
{
    $test_layout=Test::where("video_id",$id)->first();
    $quesion=Question::where("test_id",$test_layout->id)->get();
    $test=["test"=>$test_layout ,"quesion"=>$quesion];
    return ["test"=>$test,"message"=>"تم جلب الإختبار بنجاح" ,"code"=>200];


}
else {
    return ["test"=>[],"message"=>"حسابك مقيد لا يمكنك عمل هذا الإجراء" ,"code"=>403];

}
}


}
