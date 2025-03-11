<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::all();
        foreach ($roles as $role) {
            User::create([
                'name' => $role->name . ' User',  
                'email' => strtolower($role->name) . '@example.com',
                'password' => Hash::make('123456'),
                'phone' => fake()->phoneNumber(),
                'address' => fake()->address(),
                'photo' => fake()->imageUrl(100,100, 'people'),
                'role_id' => $role->id,
            ]);
        }
    }
}
