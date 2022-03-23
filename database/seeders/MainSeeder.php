<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Blog;
use App\Models\Main;
use App\Models\Offer;
use App\Models\Benefit;
use App\Models\Section;
use App\Models\Activity;
use Illuminate\Database\Seeder;

class MainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Main::factory()
            ->has(Benefit::factory()->count(5))
            ->has(Offer::factory()->count(5))
            ->has(Section::factory()->count(5))
            ->has(Blog::factory()->count(25))
            ->has(Activity::factory()->count(10))
            ->create();
    }
}
