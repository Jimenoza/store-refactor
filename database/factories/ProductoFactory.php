<?php

use Faker\Generator as Faker;

$factory->define(tiendaVirtual\Producto::class, function (Faker $faker) {
    return [
      'nombre' => $faker->unique()->word,
      'descripcion' => $faker->text,
      'imagen' => 'play1.jpg',
      'precio' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.99, $max = NULL),
      'categoria' => '1',
      'stock' => $faker->numberBetween($min = 1, $max = 999),
      'estado' => '1',
    ];
});
