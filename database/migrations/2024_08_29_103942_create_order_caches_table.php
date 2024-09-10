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
        Schema::create('order_caches', function (Blueprint $table) {
            $table->id();
            $table->integer("value");
            $table->bigInteger("userId")->unsigned();
            $table->enum("status",["wating","don"])->default("wating");
            $table->foreign("userId")->references("id")->on("users");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_caches');
    }
};
