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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->longText("description");
            $table->text("video");
            $table->bigInteger("course_id")->unsigned();
            $table->bigInteger("user_id")->unsigned();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("course_id")->references("id")->on("courses")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
