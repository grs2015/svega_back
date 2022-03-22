<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->count(4)->create();

        Blog::all()->each(function($blogItem) {
            $catIds = Category::all()->random(random_int(1, 3))->pluck('id');
            $blogItem->categories()->sync($catIds);
        });
    }
}
