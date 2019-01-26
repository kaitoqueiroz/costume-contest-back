<?php

use Illuminate\Database\Seeder;
use App\User;
use App\UserCostume;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 50)->create()->each(function ($user) {

            $costume = factory(App\UserCostume::class)->create([
                'user_id' => $user->id
            ]);

            $user->costume()->save($costume);
        });
    }
}
