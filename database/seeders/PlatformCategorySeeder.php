<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlatformCategory;

class PlatformCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Survei Berbayar', 'slug' => 'survei-berbayar', 'sort_order' => 1],
            ['name' => 'Get-Paid-To (GPT)', 'slug' => 'get-paid-to', 'sort_order' => 2],
            ['name' => 'Transcription', 'slug' => 'transcription', 'sort_order' => 3],
            ['name' => 'User Testing', 'slug' => 'user-testing', 'sort_order' => 4],
            ['name' => 'Freelance', 'slug' => 'freelance', 'sort_order' => 5],
            ['name' => 'AI Task', 'slug' => 'ai-task', 'sort_order' => 6],
        ];

        foreach ($categories as $category) {
            PlatformCategory::updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'sort_order' => $category['sort_order'],
                ]
            );
        }
    }
}
