<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\AcRecord;
use App\Models\Temperature;
use App\Models\HeaterRecord;
use App\Models\WindowRecord;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //create one user with the following credentials. password is "password".
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        //run the temperature factory to generate 20 records. wait 3 seconds between each record.
        for($i = 0; $i < 20; $i++) {
            Temperature::factory()->create();
            sleep(1);
        }

        //run ac factory, heater factory, and window factory to generate 5 records each. wait 3 seconds between each burst of records.
        for($i = 0; $i < 5; $i++) {
            AcRecord::factory()->create();
            HeaterRecord::factory()->create();
            WindowRecord::factory()->create();
            sleep(3);
        }
    }
}
