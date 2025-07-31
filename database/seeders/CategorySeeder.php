<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Food & Dining', 'color' => '#EF4444', 'icon' => '🍽️'],
            ['name' => 'Transportation', 'color' => '#3B82F6', 'icon' => '🚗'],
            ['name' => 'Shopping', 'color' => '#10B981', 'icon' => '🛍️'],
            ['name' => 'Entertainment', 'color' => '#F59E0B', 'icon' => '🎬'],
            ['name' => 'Bills & Utilities', 'color' => '#8B5CF6', 'icon' => '💡'],
            ['name' => 'Healthcare', 'color' => '#EC4899', 'icon' => '⚕️'],
        ];

        $users = User::all();

        foreach ($users as $user) {
            foreach ($categories as $category) {
                Category::create([
                    'name' => $category['name'],
                    'color' => $category['color'],
                    'icon' => $category['icon'],
                    'user_id' => $user->id
                ]);
            }
        }
    }
}
