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
        Schema::table('static_contents', function (Blueprint $table) {
            $table->json("title")->change();
            $table->json("content")->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('static_contents', function (Blueprint $table) {
            $table->json("title")->change();
            $table->json("content")->change();
        });
    }
};
