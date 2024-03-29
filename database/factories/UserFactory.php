<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Ramsey\Uuid\Uuid;
use Illuminate\Notifications\DatabaseNotification;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/** @var TYPE_NAME $factory */
$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => Str::random(10),
    ];
});


$factory->define(App\Thread::class,function (Faker $faker){
    return[
        'user_id'=> function(){
            return factory('App\User')->create()->id;
        },
        'channel_id'=> function(){
            return factory('App\Channel')->create()->id;
        },
        'title' => $faker->sentence,
        'body'=> $faker->paragraph
    ];
});


$factory->define(App\Reply::class,function (Faker $faker){
    return[
        'user_id'=> function(){
            return factory('App\User')->create()->id;
        },
        'thread_id'=> function(){
            return factory('App\Thread')->create()->id;
        },
        'body'=> $faker->paragraph
    ];
});

$factory->define(App\Channel::class,function (Faker $faker){
    $name=$faker->word;
    return[
       'name'=> $name,
        'slug'=> $name
    ];
});



