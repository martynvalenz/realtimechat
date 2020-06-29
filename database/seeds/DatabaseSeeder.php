<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(User::class)->create(
            [
                'email' => 'martynvalenz@gmail.com',
                'name' => 'Martin Valenzuela'
            ]
        );
        factory(User::class)->create(
            [
                'email' => 'ankur@gmail.com',
                'name' => 'Ankur Shrivastava'
            ]
        );
        factory(User::class)->create(
            [
                'email' => 'marvin.torrentera@gmail.com',
                'name' => 'Marvin Torrentera'
            ]
        );
    }
}
