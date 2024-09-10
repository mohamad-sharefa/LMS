<?php
namespace App\services;

use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VideoService{

public function creat_videos($request):array
{

   // if(Auth::user()->hasRole("tetcher")){
    $user=User::find(Auth::id());
    $status=$user->status;
    if($status=="enable")
    {
        $course=Course::find($request["course_id"]);
        $haveCourse=$course->user_id;
        if($haveCourse==Auth::id()||Auth::user()->hasRole("admin")){

            $course=Course::find($request["course_id"]);
            $course_name=$course->name;

           // $file=$request->image;
            //$format = $file->getClientOriginalExtension();
            //generate file name
            $fileName = time() . rand(1, 999999).".mp4";

            $request->file("video")->move(public_path("/videos/$course_name"),$fileName);
            //$path = $request->file('video')->store('videosa', 'public');



            $video=Video::create([
                "name"=>$request["name"],
                "description"=>$request["description"],
                "course_id"=>$request["course_id"]??0,
                //"video_id"=>$request["video_id"]??0,
                "video"=>$fileName,
                "user_id"=>Auth::id(),



            ]);
            $message="created video successfly";
            $code=201;

            return ["video"=>$video,"message"=>$message,"code"=>$code];

        }
        else{

            return ["video"=>[],"message"=>"ان لا تملك صلاحية ","code"=>403];
        }

    /*}
    else{

        $message="forbiden";
        $code=403;
        return ["video"=>[],"message"=>$message,"code"=>$code];

    }
*/
}
else {
    return ["video"=>[],"message"=>"حسابك مقيد لا يمكنك اضافة أي فيديو جديد","code"=>403];

}

}
public function get_video_by_id($id):array
{
    $vedeo=Video::find($id);
    return["video"=>$vedeo,"message"=>"تم جلب معلومات  الفيديو","code"=>200];
}

}
