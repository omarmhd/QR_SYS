<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Plan;
use App\Models\User;
use Database\Factories\PlanFactory;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
            Admin::create([
            "name"=>"admin",
            "password"=>Hash::make("admin123"),
            "email"=>"admin@admin.com",
            "role"=>"administrator"]);
                       Plan::factory()->count(10)->create();


    }
}
