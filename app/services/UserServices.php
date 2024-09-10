<?php
namespace App\services;

use App\Models\Card;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserServices{

public function Register($request):array
{
    $fileName=null;

    if(!is_null($request->image)){

    $file=$request->image;
    $format = $file->getClientOriginalExtension();

    $fileName = time() . rand(1, 999999) . '.' . $format;

    $request->file("image")->move(public_path("/users_image"),$fileName);
    }
    else{

        $fileName="default.jpg";
    }


    $fileNamecv=null;

if(!is_null($request->cv)){
    $filecv=$request->cv;
    $formatcv = $filecv->getClientOriginalExtension();
    //generate file name
    $fileNamecv = time() . rand(1, 999999) . '.' . $formatcv;

    $request->file("cv")->move(public_path("/cv"),$fileNamecv);



}



    $status="desable";
    $stock=0;
    /*
    if(!is_null($request['status'])){
        $status=$request['status'];

    }

*/

if($request["account_type"]=="client"&&is_null($request['cv'])){

    $status="enable";


}
/*
    if(!is_null($request['cv'])&&$request["account_type"]=="tetcher"){
        $status="desables";

    }
*/
/*
    if(!is_null($request['stock'])){
        $stock=$request['stock'];

    }
    */
$user=User::create(
    [
"first_name"=>$request["first_name"],
"last_name"=>$request["last_name"],
"number"=>$request["number"],
"birth_date"=>$request["birth_date"],

"account_type"=>$request["account_type"],
"password"=>$request["password"],
"country"=>$request["country"],
"status"=>$status,
"stock"=>$stock,
"image"=>$fileName,
"cv"=>$fileNamecv


]);
$client_role=Role::query()->where("name",$request["account_type"])->first();
$user->assignRole($client_role);

$permitions=$client_role->permissions()->pluck("name")->toArray();
$user->givePermissionTo($permitions);
$user->load("roles","permissions");
$user=User::query()->find($user["id"]);
$user["token"]=$user->createToken("token")->plainTextToken;
$message="تم انشاء حساب بنجاح";
return ["user"=>$user,"message"=>$message];

}


public function Login($request):array
{
$user=User::query()->where("number",$request["number"])->first();

if(!is_null($user)){
if(!Auth::attempt($request->only(["number","password"])))
{
$message=" كلمة المرور خطأ";
$code=401;

}
else{
    $user["token"]=$user->createToken("tiken")->plainTextToken;
    $message="user Logedin successfully";
    $code=200;
}

}
else{

    $message="رقم المستخدم غير موجود";
    $code="404";
}
return ["user"=>$user,"message"=>$message,"code"=>$code];
}

public function Logout():array
{

$user=Auth::user();
if(!is_null($user))
{
Auth::user()->currentAccessToken()->delete();
$message="user Logout successfully";
$code=200;

}
else{

    $message="infaled token ";
    $code=404;
}

return ["user"=>$user,"message"=>$message,"code"=>$code];
}
public function get_user_type($type){

    $user=Auth::user();
    //if($user->hasRole("admin")){

        $users=User::where("account_type",$type)->paginate(2);
        return ["users"=>$users,"message"=>"succefyle","code"=>200];

    /*
    }
    else{
        return ["users"=>"empty","message"=>"aunuthrazation","code"=>401];


    }*/
}


public function Charge_my_account($request):array
{
    $user=User::find(Auth::id());
    $status=$user->status;
    if($status=="enable")
    {

$card=Card::where("value",$request["value"])->where("random_number",$request["key_number"])->where("status","available")->first();
if($card)
{

    $card->update([
        "user_id"=>Auth::id(),
        "status"=>"Sold"

    ]);
    $card->save();
    $user=User::where("id",Auth::id())->first();
    if($user){
        $stok=$user->stock;
        $user->update([
            "stock"=>$stok+$request["value"],

        ]);
        $user->save();
        $message="تم شحن حسابك بنجاح";
        $code=201;
        return ["card"=>$card,"message"=>$message,"code"=>$code];
    }
    else{
        $message="هناك مشكلة ب الحساب الذي تحاول شحنه";
        $code=401;
        return ["card"=>$card,"message"=>$message,"code"=>$code];

    }

    }
    else{

 $message=" يبدو أن البطاقة التي تحاول استخدامها منتهية أو الرقم غير صحيح";
        $code=403;
        return ["card"=>$card,"message"=>$message,"code"=>$code];
    }
}
else{
    return ["card"=>[],"message"=>"حسابك مقيد لا يمكنك شحنه ب النقود","code"=>403];


}


}
public function chang_my_info($request):array
{
$id=Auth::id();
$user=User::find($id);
if($user)
{

    if(!is_null($request->image)){

        //Storage::disk('public/users_image')->delete($user->image);


        $file=$request->image;
        $format = $file->getClientOriginalExtension();
        //generate file name
        $fileName = time() . rand(1, 999999) . '.' . $format;

        $request->file("image")->move(public_path("/users_image"),$fileName);
        }


/*
    $user->update([
        "first_name"=>$request["first_name"],
        "last_name"=>$request["last_name"],

        "number"=>$request["number"],

        "birthday"=>$request["birthday"],

        "country"=>$request["country"],

        "image"=>$fileName,
        "account_type"=>$request["account_type"],
        "password"=>$request["password"],
        "status"=>$request["status"],
        "stock"=>$request["stock"],
        "cv"=>$request["cv"],



    ]);



    $user->save();
*/





    $user->first_name=$request["first_name"];

    $user->last_name=$request["last_name"];

    $user->number=$request["number"];

    $user->birth_date=$request["birth_date"];

    $user->country=$request["country"];
    //$user->account_type=$request["account_type"];
    $user->password=$request["password"];

   // $user->status=$request["status"];

   // $user->stock=$request["stock"];

    if(!is_null($request->image)){
        $user->image=$fileName;

    }

/*
    if(!is_null($request->cv)){
        $user->cv=$request["cv"];

    }

*/

    $user->save();



    return ["user"=>$user,"message"=>"تم التحديث بنجاح","code"=>203];

}
else{
    return ["user"=>$user,"message"=>"هناك خطأ ما","code"=>500];


}


}


public function get_my_info():array
{
$id=Auth::id();
$user=User::find($id);
return ["user"=>$user,"message"=>"تم جلب معلومات الحساب ","code"=>200];



}


public function get_detels_account($id):array
{
$AuthId=Auth::id();
$AuthUser=User::find($AuthId);
$status=$AuthUser->status;

if($status=="enable"){



if($AuthUser)
{

$user=user::find($id);
if($user){

return ["user"=>$user,"message"=>"تم جلب معلومات الحساب المطلوب","code"=>200];

}
else{
return ["user"=>[],"message"=>"المستخدم الذي تحاول الوصول له غير متوفر","code"=>404];



}


}
else{
return ["user"=>[],"message"=>"غير مصرح لك الوصول إلى هذا المكان","code"=>403];

}


}
else{

    return ["user"=>[],"message"=>"حسابك مقيد حاليا لا يمكنك عمل هذا الإجراء","code"=>403];

}


}
public function get_users_of_6_month ():array
{
    //if(Auth::user()->hasRole("admin")){

        $now = Carbon::now();
        $sixMonthsAgo = $now->subMonths(6);

        $users = User::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->where('created_at', '>=', $sixMonthsAgo)
            ->groupBy('year', 'month')
            ->orderBy('month')
            ->get();



            $data = [
                'labels' => [],
                'data' => [],
            ];

            foreach ($users as $user) {
                $monthYear = Carbon::create($user->year, $user->month)->format('F Y');
                $data['labels'][] = $monthYear;
                $data['data'][] = $user->count;
            }



return ["users"=>$data,"message"=>"عدد المستخدمين خلال الأشهر الماضية","code"=>200];


/*
    }
    else{

        return ["users"=>[],"message"=>"عذرا أنت لا تملك صلاحيات الوصول","code"=>403];
    }
*/







}
public function enable_account($id):array
{

    //if(Auth::user()->hasRole("admin")){
        $user=User::find($id);
        if($user){

            $user->status="enable";
            $user->save();
            return ["user"=>$user,"message"=>"تم تفعيل الحساب بنجاح","code"=>201];
        }
        else{

            return ["user"=>[],"message"=>"المستخدم الذي تحاول الوصول له غير موجود","code"=>404];
        }


   // }
   /*
    else{

        return ["user"=>[],"message"=>"غير مصرح لك اجراء هذا الأمر","code"=>403];
    }
    */
}
public function desable_account($id):array{

   // if(Auth::user()->hasRole("admin")){
        $user=User::find($id);
        if($user){

            $user->status="desable";
            $user->save();
            return ["user"=>$user,"message"=>"تم تقييد الحساب بنجاح","code"=>201];
        }
        else{

            return ["user"=>[],"message"=>"المستخدم الذي تحاول الوصول له غير موجود","code"=>404];
        }


    //}
    /*
    else{

        return ["user"=>[],"message"=>"غير مصرح لك اجراء هذا الأمر","code"=>403];
    }
*/
}

}

