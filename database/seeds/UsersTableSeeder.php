<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // the user input will be a string, but the factory expects an integer so we have to cast this value to integer
        $usersCount = max((int) $this->command->ask('How many users would you like?', 20), 1);
        
        factory(App\User::class)->states('john-doe')->create();        
        factory(App\User::class, $usersCount)->create();
    }
}
