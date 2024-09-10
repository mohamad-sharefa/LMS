<?php
namespace App\services;

use App\Models\Course;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PurchasServeices{

public function buy_course($cours_id):array{

    $user=User::find(Auth::id());
$status=$user->status;
if($status=="enable")
{

    $userId=Auth::id();
    $user=User::find($userId);
    $stock=$user->stock;
    $course=Course::find($cours_id);
    $price=$course->price;

    $in_my_course=Purchase::where("user_id",$userId)->where("course_id",$cours_id)->first();
    if(!$user){
        return ["cours"=>[],"message"=>"قم بتسجيل الدخول وحاول مجدد","code"=>403];


    }

if($in_my_course)
{

    return ["cours"=>[],"message"=>"الكورس مشترى من قبل تفقد قائمة المشتريات","code"=>403];


}


else{



    if($stock>$price){
        $puchas=Purchase::create([

            "user_id"=>$userId,
            "course_id"=>$cours_id
        ]);
        $user->stock=$user->stock-$course->price;

        $tetcher_of_cours=$course->user_id;
        $tetcher=User::find($tetcher_of_cours);
        $tetcher->stock=$tetcher->stock+$course->price;

        $tetcher->save();
        $user->save();

return ["cours"=>$puchas,"message"=>"تمت عملية الشراء بنجاح","code"=>201];


    }
    else{
        return["cours"=>[],"message"=>"لا تملك نقود كافية قم بشحن الحساب ","code"=>403];
    }

}
}
else{
    return["cours"=>[],"message"=>"حسابك مقيد لا يمكنك شراء الكورسات","code"=>403];

}

}
public function get_my_cours_buy():array{
    $user=User::find(Auth::id());
$status=$user->status;
if($status=="enable")
{


$id=Auth::id();
$my_courses=Purchase::where("user_id",$id)->get()->toArray();
$data=[];
foreach($my_courses as $my_course){





    $courses = Course::select('courses.*','users.first_name as first_name','users.last_name as last_name')->where("courses.id",$my_course["course_id"])
    ->leftJoin('ratings', 'courses.id', '=', 'ratings.course_id')
    ->leftJoin('users', 'courses.user_id', '=', 'users.id')
     ->selectRaw('courses.*, AVG(ratings.value) as avg_rating')
     ->groupBy('courses.id')
     ->groupBy('courses.name')
     ->groupBy('courses.description')
     ->groupBy('courses.price')
     ->groupBy('courses.status')
     ->groupBy('courses.image')
     ->groupBy('courses.section_id')
     ->groupBy('courses.user_id')
     ->groupBy('courses.created_at')
     ->groupBy('courses.updated_at')
     ->orderByDesc('avg_rating')
     ->groupBy('users.first_name')
     ->groupBy('users.last_name')

     ->get()->toArray();





    //$courses=Course::where("id",$my_course["course_id"])->get()->toArray();
    array_push($data, ...$courses);

}
return ["data"=>$data,"message"=>"جميع الكورسات التي اشتريتها","code"=>200];

}
else {
    return ["data"=>[],"message"=>" حسابك مقيد  لا يمكنك  تصفح كورساتك","code"=>403];

}
}



}
