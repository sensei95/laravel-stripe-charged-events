<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::factory(8)->create();

        $admin = \App\Models\User::factory()->create([
            'name' => 'kitadi elie',
            'email' => 'elk.dev.official@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        \App\Models\User::factory(10)->create()->each(function ($user) use ($tags){
            Event::factory(rand(2,5))->create([
                'user_id' => $user->id
                ])->each(function($event) use ($tags){
               $event->tags()->attach($tags->random(3));
            });
        });

        Event::factory(rand(2,5))->create([
            'user_id' => $admin->id
            ])->each(function ($event) use ($tags) {
            $event->tags()->attach($tags->random(3));
        });
    }
}
