<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    // protected $toTruncate = ['users', 'agenda', 'team'];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment('local')) {
            // foreach($this->toTruncate as $table) {
            //     DB::table($table)->truncate();
            // }
            // \App\Models\User::factory(3)->create();
            $this->call([
                UsersTableSeeder::class,
                CalendarsTableSeeder::class,
                PermanencesTableSeeder::class,
            ]);
        }
    }
}
