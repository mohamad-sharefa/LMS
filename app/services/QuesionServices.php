<?php
namespace App\Services;

use App\Models\Question;
use App\Models\Test;
use Illuminate\Support\Facades\Auth;

class QuesionServices{



public function creat_quesion($request):array
{


    //if(Auth::user()->hasRole("tetcher")){

        $user=User::find(Auth::id());
        $status=$user->status;
        if($status=="enable")
        {

$test=Test::where("id",$request["test_id"])->where("user_id",Auth::id())->first();
if($test){



        $quesion=Question::create([


            "question_text"=>$request["question_text"],
            "option_a"=>$request["option_a"],
            "option_b"=>$request["option_b"],
            "option_c"=>$request["option_c"],
            "option_d"=>$request["option_d"],
            "correct_option"=>$request["correct_option"],
            "test_id"=>$request["test_id"],

        ]);
        $message="تم اضافة سؤال جديد للإختبار بنجاح";
        $code=201;


return ["quesion"=>$quesion,"message"=>$message,"code"=>$code];

    }
    else{

           $message="  عذرا  الإختبار ليس تابع لك لا يمكنك عم اي اجراء عليه";
        $code=403;


return ["quesion"=>[],"message"=>$message,"code"=>$code];
    }


}
else{
    return ["quesion"=>[],"message"=>"حسابك مقيد لا يمكنك  انشاء سؤال","code"=>403];


}
   /* }

    else{

        $message="عذرا هذا الإجراء مخصص للمدرسين فقط";
     $code=403;


return ["quesion"=>[],"message"=>$message,"code"=>$code];
 }
*/
}

}
