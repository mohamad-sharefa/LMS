<?php
namespace App\services;

use App\Models\Order_cach;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Order_cachServices {
public function get_all_orders():array{
    $id=Auth::id();
    $user=User::find($id);
    if($user->hasRole("admin")){
        $order=Order_cach::select('order_caches.*' ,'users.first_name as first_name','users.last_name as last_name')
        ->leftJoin('users', 'order_caches.userId', '=', 'users.id')
        ->groupBy('order_caches.id')
        ->groupBy('order_caches.value')
        ->groupBy('order_caches.userId')
        ->groupBy('order_caches.status')
        ->groupBy('order_caches.created_at')

        ->groupBy('order_caches.updated_at')



        ->groupBy('users.first_name')
        ->groupBy('users.last_name')


        ->get();
        return ["order"=>$order,"message"=>"تم جلب جميع الطلبات بنجاح","code"=>200];

    }
    else{
        return ["order"=>[],"message"=>"غير مصرح لك الوصول إلى هذه الإجراء","code"=>403];

    }




}
public function Create_new_order_cach($value):array{

    $id=Auth::id();
    $user=User::find($id);
    $stock=$user->stock;
    if($user->hasRole("tetcher")&&$stock>=$value){

        $order=Order_cach::create([

            "userId"=>$id,
            "value"=>$value,
            "status"=>"wating"
        ]);
        //$user->stock-=$value;
       // $user->save();
        return ["order"=>$order,"message"=>"تم طلب سحب الرصيد سيراجع من الأدمن وتتم عملية التحويل","code"=>201];
    }
    else{

        return ["order"=>[],"message"=>"عذرا الرصيد الذي طلبته اكبر من قيمة حسابك","code"=>403];
    }
}
public function accept_order($ide):array{

    $id=Auth::id();
    $user=User::find($id);
    if($user->hasRole("admin")){
        $order=Order_cach::find($ide);
        $order->status="don";
        $userId=$order->userId;
        $userr=User::find($userId);
        $userr->stock-=$order->value;
        $userr->save();
        $order->save();
        return["data"=>$order,"message"=>"تمت عملية القبول بنجاح ","code"=>201];



    }
    else{
        return["data"=>[],"message"=>"خطأ ما أدى إلى الفشل","code"=>403];


    }
}

}
