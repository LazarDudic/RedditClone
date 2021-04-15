<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([CategorySeeder::class]);
        \App\Models\User::factory([
            'email' => 'user@email.com',
        ])->create();
        \App\Models\User::factory(2)->create();
        \App\Models\Topic::factory(40)->create();
        \App\Models\Answer::factory(150)->create();
    }
}
