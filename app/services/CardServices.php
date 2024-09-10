<?php
namespace App\services;

use App\Models\Card;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CardServices
  {

public function Create_cards($request):array
{

//if(Auth::user()->hasRole("admin")){




    $numbers = [];
    while (count($numbers) < $request["number"]) {
        $randomNumber = rand(100000, 999999);
        if (!in_array($randomNumber, $numbers)) {
            $numbers[] = $randomNumber;
        }
    }



    foreach ($numbers as  $number) {
        $value=$request["value"];
        Card::create([
            'random_number'=>$number,
            'value'=>$value??0,
            "user_id"=>Auth::id()

        ]);




}
$message="تم انشاء لأرقام البطاقات بنجاح";
$code=201;
return ["cards"=>$numbers,"message"=>$message,"code"=>$code];
/*
}
else{
    $message="غير مصرح لك القيام بهذا الأمر";
    $code=403;
    return ["cards"=>[],"message"=>$message,"code"=>$code];

}
*/


}
public function get_all_cards():array{

    $id=Auth::id();
    $user=User::find($id);
    if($user->hasRole("admin")){

        $cards=Card::get();
        return ["data"=>$cards,"message"=>" جميع البطاقات ","code"=>200];
    }
    else{
        return ["data"=>[],"message"=>"غير مصرح لك الوصول","code"=>403];

    }
}
  }
