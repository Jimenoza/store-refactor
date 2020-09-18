<?php

use Faker\Generator as Faker;

$factory->define(tiendaVirtual\Category::class, function (Faker $faker) {
    return [
        'nombre' => $faker->unique()->word,
        'descripcion' => $faker->text,
        'condicion' => '1',
    ];
});
