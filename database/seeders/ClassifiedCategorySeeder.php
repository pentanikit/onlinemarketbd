<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Classifieds\Models\ClassifiedCategory;

class ClassifiedCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics', 'icon' => '💻', 'sort_order' => 1],
            ['name' => 'Vehicles', 'slug' => 'vehicles', 'icon' => '🚗', 'sort_order' => 2],
            ['name' => 'Property', 'slug' => 'property', 'icon' => '🏠', 'sort_order' => 3],
            ['name' => 'Home & Living', 'slug' => 'home-living', 'icon' => '🛋️', 'sort_order' => 4],
            ['name' => 'Pets & Animals', 'slug' => 'pets-animals', 'icon' => '🐶', 'sort_order' => 5],
            ['name' => 'Mens Fashion & Grooming', 'slug' => 'mens-fashion-grooming', 'icon' => '👕', 'sort_order' => 6],
            ['name' => 'Hobbies, Sports & Kids', 'slug' => 'hobbies-sports-kids', 'icon' => '⚽', 'sort_order' => 7],
            ['name' => 'Women\'s Fashion & Beauty', 'slug' => 'womens-fashion-beauty', 'icon' => '👗', 'sort_order' => 8],
            ['name' => 'Business & Industry', 'slug' => 'business-industry', 'icon' => '🏭', 'sort_order' => 9],
            ['name' => 'Education', 'slug' => 'education', 'icon' => '🎓', 'sort_order' => 10],
            ['name' => 'Essentials', 'slug' => 'essentials', 'icon' => '🛒', 'sort_order' => 11],
            ['name' => 'Jobs', 'slug' => 'jobs', 'icon' => '💼', 'sort_order' => 12],
            ['name' => 'Services', 'slug' => 'services', 'icon' => '🛠️', 'sort_order' => 13],
            ['name' => 'Agriculture', 'slug' => 'agriculture', 'icon' => '🌾', 'sort_order' => 14],
            ['name' => 'Overseas Jobs', 'slug' => 'overseas-jobs', 'icon' => '🧳', 'sort_order' => 15],
            ['name' => 'Mobiles', 'slug' => 'mobiles', 'icon' => '📱', 'sort_order' => 16],
        ];

        foreach ($categories as $category) {
            ClassifiedCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category + ['is_active' => true]
            );
        }
    }
}