<?php
namespace App\services;
use App\Models\view;
use Illuminate\Support\Facades\Auth;

class ViewService{

public function create_view($request):array
{

$view=view::create([
"user_id"=>Auth::id(),
"video_id"=>$request["video_id"],




]);
$message="don";
$code=201;

return ["view"=>$view,"message"=>$message,"code"=>$code];

}
public function get_views($id):array{
    $viewsCount = View::where("video_id", $id)->count();
    return ["data"=>$viewsCount,"message"=>"عدد مشاهدات الفيديو" ,"code"=>"200"];


}

}
