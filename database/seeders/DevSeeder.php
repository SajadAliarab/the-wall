<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DevSeeder extends Seeder
{
    public function run(): void
    {
        $user = new User;
        $user->name = 'admin';
        $user->email = 'admin@dev.local';
        $user->email_verified_at = now();
        $user->password = 'abc@123';
        $user->is_admin = true;
        $user->save();

        $parentCategory = new Category;
        $parentCategory->name = 'Eletronics';
        $parentCategory->save();

        $childCategory = new Category;
        $childCategory->name = 'Mobile';
        $childCategory->parent_id = $parentCategory->id;
        $childCategory->save();
    }
}
