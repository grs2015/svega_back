<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Activity;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::factory()->count(4)->create();

        Activity::all()->each(function($activityItem) {
            $tagIds = Tag::all()->random(random_int(1, 3))->pluck('id');
            $activityItem->tags()->sync($tagIds);
        });
    }
}
