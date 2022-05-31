<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
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
        User::factory(10)->create();
        
        Role::create([
            'name' => 'admin'
        ]);
        
        Role::create([
            'name' => 'seller'
        ]);

        Role::create([
            'name' => 'customer'
        ]);
        
        RoleUser::factory(10)->create();
        
        Product::factory(999)->create();
    }
}
