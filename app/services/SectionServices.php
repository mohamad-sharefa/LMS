<?php
namespace App\services;

use App\Http\Requests\SectionRequest;
use App\Models\Course;
use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SectionServices{

public function index():array
{


    $sections=Section::get();
    return ["sections"=>$sections,"message"=>"All sections","code"=>200];





}
public function Creat_section($sectionRequest):array

{
//if(Auth::user()->hasRole("admin")){


    $file=$sectionRequest->image;
    $format = $file->getClientOriginalExtension();
    //generate file name
    $fileName = time() . rand(1, 999999) . '.' . $format;

    $sectionRequest->file("image")->move(public_path("/Section_image"),$fileName);

    $sections=Section::create([
    "name"=>$sectionRequest["name"],
    "description"=>$sectionRequest['description'],
    "image"=>$fileName


    ]);
    $message="create section successfly ";
    $code=201;
    return ["section"=>$sections,"message"=>$message,"code"=>$code];

/*
}
else{

    $message="Forbidden";
    $code=403;
    return ["section"=>[],"message"=>$message,"code"=>$code];

}*/

}
public function Updat_section($sectionRequest,$id):array
{

//if(Auth::user()->hasRole("admin")){

    $section=Section::find($id);
    if($section){


        if($sectionRequest->hasFile("image")){
            $file=$sectionRequest["image"];
            $format = $file->getClientOriginalExtension();
            //generate file name
            $fileName = time() . rand(1, 999999) . '.' . $format;

            $sectionRequest->file("image")->move(public_path("/Section_image"),$fileName);
                $section->name=$sectionRequest->name;
                $section->description=$sectionRequest->description;
                $section->image=$fileName;




                $section->save();
                /*
                $section->name=$request["name"];
                $section->description=$request["description"];
                $section->image=$fileName;
                $section->save();
*/
            $message="updated successfly";
            $code=201;
            return ["section"=>$section,"message"=>$message,"code"=>$code];

        }
        else{
            $section->update([
            "name"=>$sectionRequest["name"],
            "description"=>$sectionRequest["description"],
            "image"=>$section->image,
            $section->save()
            ]);


            $message="updated successfly";
            $code=201;
            return ["section"=>$section,"message"=>$message,"code"=>$code];
        }


    }

else{
    $message="not found";
    $code=404;
    return["section"=>[],"message"=>$message,"code"=>$code];

}

/*}
else{
    $message="forbiden";
    $code=403;
    return["section"=>[],"message"=>$message,"code"=>$code];

}*/

}
public function delete_section($id):array
{
    $section=Section::find($id);
    if($section)
    {

      //  if(Auth::user()->hasRole("admin")){
$section->delete();

            $message="deleted successfly";
        $code=200;
        return ["section"=>$section,"message"=>$message,"code"=>$code];
        }
    /*}
    else{
        $message="not found";
        $code=404;
        return["section"=>[],"message"=>$message,"code"=>$code];
    }*/


    $message="forbiden";
$code=403;
return["section"=>[],"message"=>$message,"code"=>$code];
}
public function get_section_by_id($id):array
{
$section=Section::find($id)->toArray();
//$courses=Course::where("section_id",$id)->where("status","enable")->get()->toArray();
$courses = Course::select('courses.*','users.first_name as first_name','users.last_name as last_name')->where('courses.status', 'enable')->where("section_id",$id)
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
$data=["section"=>$section,"courses"=>$courses];
return ["data"=>$data,"message"=>"تم جلب معلومات القسم والكورسات المرتبطة به ","code"=>200];

}

}
