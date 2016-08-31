<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
            $this->call(AccountGroupSeeder::class);
            $this->call(UserTypeSeeder::class);
            $this->call(SecretQuestionSeeder::class);
            // $this->call(HomeOwnerSeeder::class);
            // $this->call(UserSeeder::class);
        Model::reguard();
    }
}
