<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(
            [
                'id' => 1
            ], [
                'company_id'        => 1,
                'name'              => 'Mr. Admin',
                'email'             => 'admin@gmail.com',
                'email_verified_at' => today(),
                'password'          => Hash::make('12345678'),
            ]
        );
      
    }
}
