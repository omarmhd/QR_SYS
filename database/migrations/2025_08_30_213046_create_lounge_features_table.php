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
        Schema::create('lounge_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId("lounges_id")->constrained("lounges")->cascadeOnDelete();
            $table->foreignId("features_id")->constrained("features")->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lounge_features');
    }
};
