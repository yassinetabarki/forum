<?php

use Faker\Generator as Faker;
use Illuminate\Notifications\DatabaseNotification;
use Ramsey\Uuid\Uuid;

$factory->define(DatabaseNotification::class, function (Faker $faker) {
    return [
        'id' => Uuid::uuid4()->toString(),
        'type' => 'App\Notifications\ThreadWasUpdated',
        'notifiable_id' => function (){
             return auth()->id() ?: factory('App\User')->create()->id;
         },
         'notifiable_type' => 'App\User',
         'data' => ['foo' => 'bar'],

    ];
});
