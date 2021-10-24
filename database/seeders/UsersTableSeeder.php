<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->firstOrCreate([], [
            'last_name' => 'Super',
            'first_name' => 'Admin',
            'patronymic' => 'Forever',
            'email' => 'admin@test.test',
            'phone_number' => '+70000000000',
            'birthdate' => now()->modify('-23 years'),
            'password' => Hash::make('secret'),
        ]);
    }
}
