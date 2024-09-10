<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole=Role::create(["name"=>"admin"]);
        $tetchRole=Role::create(["name"=>"tetcher"]);

        $clientRole=Role::create(["name"=>"client"]);
        $permitions=[

            "show_all_user",
            "create_corse",
            "show_corse",
            "update_corse",
            "delete_corse",
            "updtae_my_info",
            "get_my_info",
            "delet_my_account",
            "logout",
            "get_user_of_type",
            "get_details_account",
            "enable_account",
            "desable_account",
            "get_user_of_6_month",
            "get_all_section",
            "creat_new_section",
            "update_section",
            "delete_section",
            "get_all_course",
            "get_my_course",
            "delet_my_course",
            "add_rating",
            "create_comments",
            "get_course_by_id",
            "delete_comments",
            "create_video",
            "create_cards",
            "charg_my_account",
            "create_new_test",
            "get_test_of_course",
            "get_test_of_video",
            "creat_new_quession",
            "update_quession",
            "delete_quession",
            "buy_new_course",
            "get_my_course_buy",
            "desable_course",
            "enable_course",
            "get_all_order",
            "create_new_order_cash",



        ];
        $adminPermission=[
            "show_all_user",
            "create_corse",
            "show_corse",
            "update_corse",
            "delete_corse",
            "updtae_my_info",
            "get_my_info",
            "delet_my_account",
            "logout",
            "get_user_of_type",
            "get_details_account",
            "enable_account",
            "desable_account",
            "get_user_of_6_month",
            "get_all_section",
            "creat_new_section",
            "update_section",
            "delete_section",
            "get_all_course",
            "get_my_course",
            "delet_my_course",
            "add_rating",
            "create_comments",
            "get_course_by_id",
            "delete_comments",
            "create_video",
            "create_cards",
            "charg_my_account",
            "create_new_test",
            "get_test_of_course",
            "get_test_of_video",
            "creat_new_quession",
            "update_quession",
            "delete_quession",
            "buy_new_course",
            "get_my_course_buy",
            "desable_course",
            "enable_course",
            "get_all_order",
    ];
    $tetcherPermission=[

            "create_corse",
            "show_corse",
            "update_corse",
            "delete_corse",
            "updtae_my_info",
            "get_my_info",
            "delet_my_account",
            "logout",
            "get_details_account",
            "get_all_section",
            "get_all_course",
            "get_my_course",
            "delet_my_course",
            "add_rating",
            "create_comments",
            "get_course_by_id",
            "delete_comments",
            "create_video",
            "charg_my_account",
            "create_new_test",
            "get_test_of_course",
            "get_test_of_video",
            "creat_new_quession",
            "update_quession",
            "delete_quession",
            "buy_new_course",
            "get_my_course_buy",
            "create_new_order_cash",

    ];
    $clientPermission=[
        "show_corse",
        "updtae_my_info",
        "get_my_info",
        "delet_my_account",
        "logout",
        "get_details_account",
        "get_all_section",
        "get_all_course",
        "add_rating",
        "get_my_course_buy",
        "buy_new_course",
        "get_test_of_course",
        "get_test_of_video",
        "charg_my_account",
        "delete_comments",
        "get_course_by_id",
        "create_comments",


    ];
        foreach($permitions as $permition){
            Permission::findOrCreate($permition,"web");
        }
        $adminRole->syncPermissions($adminPermission);
        $tetchRole->syncPermissions($tetcherPermission);

        $clientRole->syncPermissions($clientPermission);



        $adminUser=User::factory()->create(
            [
                "first_name"=>"mohamad",
                "last_name"=>"sharefa",
                "number"=>"0992104287",
                "birth_date"=>"2000-05-09",
                "status"=>"enable",
                "stock"=>0,
                "country"=>"siray",
                "account_type"=>"admin",
                "image"=>Carbon::today(),
                "password"=>bcrypt("password")
                ]
        );
        $adminUser->createToken("token")->plainTextToken;
            $adminUser->assignRole($adminRole);


            $permition=$adminRole->permissions()->pluck("name")->toArray();
                $adminUser->givePermissionTo($adminPermission);






                $tetcherUser=User::factory()->create(
                    [
                        "first_name"=>"yamen",
                        "last_name"=>"njm",
                        "number"=>"0957355496",
                        "birth_date"=>"2001-07-07",
                        "status"=>"enable",
                        "stock"=>0,
                        "country"=>"siray",
                        "account_type"=>"tetcher",
                        "image"=>time(),

                        "password"=>bcrypt("password")
                        ]
                );
                $tetcherUser->createToken("token")->plainTextToken;
                    $tetcherUser->assignRole($tetchRole);
                    $permition=$tetchRole->permissions()->pluck("name")->toArray();
                    $tetcherUser->givePermissionTo($tetcherPermission);











                $clientUser=User::factory()->create(
                    [
                        "first_name"=>"yara",
                        "last_name"=>"kaka",
                        "number"=>"0957355494",
                        "birth_date"=>"2003-05-05",
                        "status"=>"enable",
                        "stock"=>0,
                        "country"=>"siray",
                        "account_type"=>"client",
                        "image"=>time(),

                        "password"=>bcrypt("password")
                        ]
                );
                $clientUser->createToken("token")->plainTextToken;
                    $clientUser->assignRole($clientRole);
                    $permition=$clientRole->permissions()->pluck("name")->toArray();
                    $clientUser->givePermissionTo($clientPermission);

    }
}
