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
        Schema::create('lounges', function (Blueprint $table) {
            $table->id();
            $table->json("name")->nullable();
            $table->json("excerpt")->nullable();
            $table->json("description")->nullable();
            $table->string("image");
            $table->time("open_time");
            $table->time("close_time");
            $table->string("latitude");
            $table->string("longitude");
            $table->json("terms")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lounges');
    }
};
