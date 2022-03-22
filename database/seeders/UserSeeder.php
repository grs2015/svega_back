<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(10)->state(new Sequence(
            ['role' => User::REGULAR_USER],
            ['role' => User::EDITOR_USER],
            ['role' => User::MANAGER_USER],
        ))->create();

        User::factory()->count(1)->adminUser()->create();
    }
}
