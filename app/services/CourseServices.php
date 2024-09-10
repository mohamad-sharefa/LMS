<?php
namespace App\services;

use App\Models\Coment;
use App\Models\Course;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;

class CourseServices{
public function index():array{


    $courses = Course::select('courses.*','users.first_name as first_name','users.last_name as last_name')


    ->leftJoin('ratings', 'courses.id', '=', 'ratings.course_id')
    ->leftJoin('purchases', 'courses.id', '=', 'purchases.course_id')
    ->where('courses.status', 'enable')
       ->leftJoin('users', 'courses.user_id', '=', 'users.id')
        ->selectRaw('courses.*, AVG(ratings.value) as avg_rating ,COUNT(purchases.course_id) as purchase')
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

        ->get();


//$course=Course::orderByDesc("rating")->paginate(10);
$message="All course";
$code=200;

return["courses"=>$courses,"message"=>$message,"code"=>$code];

}







public function get_cours_of_tetcher($id):array{


    $courses = Course::select('courses.*','users.first_name as first_name','users.last_name as last_name')->where('courses.status', 'enable')->where("users.id",$id)
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

        ->get();


//$course=Course::orderByDesc("rating")->paginate(10);
$message="All course";
$code=200;

return["courses"=>$courses,"message"=>$message,"code"=>$code];

}



public function create_course($request):array
{
    $user=User::find(Auth::id());
    $status=$user->status;
    if($status=="enable")
    {
//if(Auth::user()->hasRole("tetcher")){
    if($request->hasFile("image")){
        $file=$request->image;
        $format = $file->getClientOriginalExtension();
        //generate file name
        $fileName = time() . rand(1, 999999) . '.' . $format;

        $request->file("image")->move(public_path("/course_image"),$fileName);
        $my_courses=Course::where("user_id",Auth::id())->get()->toArray();
        foreach($my_courses as $my_course){


            if($my_course["name"]==$request["name"]){

            return ["courses"=>[],"message"=>"لديك كورس بالفعل بنفس الإسم ","code"=>403];
            }
        }

        $corse=Course::create([
            "name"=>$request["name"],
            "description"=>$request["description"],
            "section_id"=>$request["section_id"],
            "price"=>$request["price"],
            "status"=>$request["status"]??"desabel",

            "user_id"=>Auth::id(),
            "image"=>$fileName,



            ]);
            $message="created succefly";
            $code=201;

            return["courses"=>$corse,"message"=>$message,"code"=>$code];
    }
    else{

        $corse=Course::create([
            "name"=>$request["name"],
            "description"=>$request["description"],
            "section_id"=>$request["section_id"],
            "user_id"=>Auth::id(),
            "image"=>"default_course_photo.jpg",



            ]);

            $message="created succefly";
            $code=201;

            return["courses"=>$corse,"message"=>$message,"code"=>$code];
        }

    }
/*
}
else{

    $message="not alaowd ";
    $code=403;

    return["courses"=>[],"message"=>$message,"code"=>$code];
}
*/


else{
    return["courses"=>[],"message"=>"الحساب مقيد لا يمكنك انشاء كورس","code"=>403];


}
}


public function search_course($request):array
{
    $courses = Course::select('courses.*','users.first_name as first_name','users.last_name as last_name')->where('courses.status', 'enable')->where('name', 'LIKE', "%$request%")
    ->orWhere('description', 'LIKE', "%$request%")
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

     ->get();
         $message="All course";
            $code=200;
     return["courses"=>$courses,"message"=>$message,"code"=>$code];

}

public function get_my_course():array
{
//if(Auth::user()->hasRole("tetcher")){
    $id=Auth::id();
   // $course=Course::where("user_id",$id)->get();


    $course = Course::select('courses.*','users.first_name as first_name','users.last_name as last_name')->where('courses.status', 'enable')->where("users.id",$id)
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

     ->get();








    $message="All my courses";
    $code=200;
    return ["courses"=>$course,"message"=>$message,"code"=>$code];


/*}
else{
    $message="not allawod";
    $code=403;
    return ["courses"=>[],"message"=>$message,"code"=>$code];

}*/


}
public function delet_my_course($id):array
{
//if(Auth::user()->hasRole("tetcher")){
$course=Course::find($id);
$user_id=$course->user_id;
if($user_id==Auth::id()||Auth::user()->hasRole("admin")){

    //$course->delete();
    $course->update(
[

    $course->status="desable",

]
    );
    $course->save();

    $message="deleted successfly";
    $code=200;
    return ["course"=>$course,"message"=>$message,"code"=>$code];
}
else{
    $message="you dont have this course ";
    $code=403;
    return ["course"=>[],"message"=>$message,"code"=>$code];

}
/*
}
else{
    $message="not allawod";
    $code=403;
    return ["course"=>[],"message"=>$message,"code"=>$code];
}
*/
}
public function get_cours_by_id($id):array
{

    $courees=Course::where("id",$id)->first()->toArray();
    $comments = Coment::with('user')
    ->where('course_id', $id)
    ->get()
->toArray();
$video=[];
$courspurchas=Purchase::where("user_id",Auth::id())->where("course_id",$id)->get();
if($courspurchas){
    $video=Video::where("course_id",$id)->get()->toArray();


}
$data=["course"=>$courees,"comments"=>$comments,"videos"=>$video];




    $message="don";
    $code=200;
    return ["course"=>$data,"message"=>$message,"code"=>$code];

}
public function desable_course($id):array
{

    $course=Course::find($id);
    $course->status="desable";
    $course->save();
    return ["course"=>$course,"message"=>"تم تقييد الكورس بنجاح","code"=>203];
}

public function enable_course($id):array
{

    $course=Course::find($id);
    $course->status="enable";
    $course->save();
    return ["course"=>$course,"message"=>"تم إلغاء تقيد الكورس بنجاح","code"=>203];
}

}
