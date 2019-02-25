<?php

use Faker\Generator as Faker;

$factory->define(App\Game::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'total_number_of_players' => $faker->numberBetween($min = 2, $max = 10),
    ];
});
