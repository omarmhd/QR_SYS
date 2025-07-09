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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');                   
            $table->decimal('price', 8, 2);           
            $table->string('currency', 3)->default('EUR');
            $table->enum('billing_type', ['day', 'month', 'year']);
            $table->boolean('is_popular')->default(false);
            $table->json('features')->nullable();
            $table->text('description')->nullable(); 
            $table->unsignedInteger('guest_passes_per_year')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
