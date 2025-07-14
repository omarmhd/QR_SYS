<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Plan;
use Database\Factories\PlanFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


           Plan::factory()->count(10)->create();

    }
}
