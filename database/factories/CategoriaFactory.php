<?php

use Faker\Generator as Faker;

$factory->define(tiendaVirtual\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
        'description' => $faker->text,
        'enable' => '1',
    ];
});
