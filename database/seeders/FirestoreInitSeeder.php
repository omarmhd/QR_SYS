<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FirestoreInitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app("firestore")->initializeCountsFromDatabase();
    }
}
