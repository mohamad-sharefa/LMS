<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\ComentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\OrderCachController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ViewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// users api//

Route::get("fetch-all-users",[UserController::class, "index"])->middleware("auth:sanctum","can:show_all_user");
Route::post("register",[UserController::class, "Register"]);
Route::get("get-info-account/{id}",[UserController::class,"get_details_account"])->middleware("auth:sanctum","can:get_details_account");
;
Route::get("get-my-info",[UserController::class ,"get_my_info"])->middleware("auth:sanctum","can:get_my_info");
Route::post("enable-account/{id}",[UserController::class ,"enable_account"])->middleware("auth:sanctum","can:enable_account");
Route::post("desable-account/{id}",[UserController::class ,"desable_account"])->middleware("auth:sanctum","can:enable_account");

Route::post("updet-my-info",[UserController::class ,"updet_my_info"])->middleware("auth:sanctum","can:updtae_my_info");
Route::get("get_users_of_6_month",[UserController::class,"get_users_of_6_month"])->middleware("auth:sanctum","can:get_user_of_6_month");
Route::post("login",[UserController::class, "Login"]);
Route::get("logout",[UserController::class, "Logout"])->middleware("auth:sanctum");
Route::delete("delet-my-account",[UserController::class, "Delete_My_Account"])->middleware("auth:sanctum");

//راوت اذا ما في توكين
Route::get("unAutherization",[UserController::class, "Token_not_found"])->name("unAutherization");
Route::get("get-user-type/{type}",[UserController::class,"get_user_type"])->middleware("auth:sanctum","can:get_user_of_type");
Route::get("get-all-sections",[SectionController::class,"index"]);
Route::post("create-section",[SectionController::class ,"Create_Section"])->middleware("auth:sanctum","can:creat_new_section");
Route::post("update-section/{id}",[SectionController::class,"update_section"])->middleware("auth:sanctum","can:update_section");
Route::delete("delete-section/{id}",[SectionController::class,"delete_section"])->middleware("auth:sanctum","can:delete_section");
Route::get("get-section-by-id/{id}",[SectionController::class ,"get_section_by_id"]);
Route::get("get-all-courses",[CourseController::class, "index"]);
Route::get("search/{value}",[CourseController::class, "search"]);




Route::post("create-course",[CourseController::class , "Create_cours"])->middleware("auth:sanctum","can:create_corse");
Route::get("get-my-course",[CourseController::class , "get_my_courses"])->middleware("auth:sanctum","can:get_my_course");

Route::get("get-course-of-tetcher/{id}",[CourseController::class , "get_courses_of_tetcher"]);
Route::get("delete-my-course/{id}",[CourseController::class ,"delet_my_course"])->middleware("auth:sanctum","can:delet_my_course");
Route::get("enable-course/{id}",[CourseController::class,"enable_course"])->middleware("auth:sanctum","can:enable_course");
Route::get("desable-course/{id}",[CourseController::class,"desable_course"])->middleware("auth:sanctum");

Route::post("add-rating",[RatingController::class, "add_rating"])->middleware("auth:sanctum","can:add_rating");

////يحتاج تعديل
Route::get("get-rating",[RatingController::class ,"get_rating"]);


Route::post("creat-comment",[ComentController::class ,"creat_comment"])->middleware("auth:sanctum","can:create_comments");
Route::get("get-course-by-id/{id}",[CourseController::class ,"get_course_by_id"]);
Route::post("creat-video",[VideoController::class,"create_video"])->middleware("auth:sanctum","can:create_video");
Route::post("creat-view",[ViewController::class ,"create_view"])->middleware("auth:sanctum");
Route::delete("delet-comment/{id}",[ComentController::class ,"delet_comment"])->middleware("auth:sanctum");
Route::post("create-card",[CardController::class ,"Create_card"])->middleware("auth:sanctum","can:create_cards");
Route::get("get-cards",[CardController::class ,"get_all_cardss"])->middleware("auth:sanctum");


Route::post("charge-my-account",[UserController::class,"Charge_my_account"])->middleware("auth:sanctum");

Route::post("creat-new-test",[TestController::class,"create_test"])->middleware("auth:sanctum","can:create_new_test");
Route::get("get-test-of-course/{id}",[TestController::class,"get_test_courst"]);
Route::get("get-test-of-video/{id}",[TestController::class,"get_test_video"]);
Route::post("creat-new-quesion",[QuestionController::class,"create_quesion"])->middleware("auth:sanctum","can:creat_new_quession");

Route::post("buy-new-course/{id}",[PurchaseController::class ,"buy_cours"])->middleware("auth:sanctum");
Route::get("get-my-cours-buy",[PurchaseController::class ,"get_my_cours_buy"])->middleware("auth:sanctum");
Route::get("get-video-by-id/{id}",[VideoController::class ,"get_video_by_ide"]);


Route::post("create-new-order-cach/{value}",[OrderCachController::class,"create_order_cach"])->middleware("auth:sanctum","can:create_new_order_cash");

Route::get("get-all-order",[OrderCachController::class,"get_all_order"])->middleware("auth:sanctum","can:get_all_order");
Route::get("accept-order/{id}",[OrderCachController::class,"accept_ordera"])->middleware("auth:sanctum",);
Route::get("get-view/{id}",[ViewController::class,"get_view"]);
