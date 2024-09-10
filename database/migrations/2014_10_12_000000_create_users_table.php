<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->bigInteger("number")->unique();

            $table->string("country");
            $table->longText("image");
            $table->longText("cv")->nullable();

            $table->enum("account_type",["admin","tetcher","client"])->default("client");
            $table->date("birth_date");
            $table->enum("status",["enable","desable"])->default("enable");
            $table->bigInteger("stock")->default(0);



            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
