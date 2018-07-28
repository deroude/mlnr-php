<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
 */

$factory->define(App\Domain\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'password' => password_hash('12345', PASSWORD_BCRYPT, ['cost' => 11]),
        'role' => $faker->randomElement(App\Domain\User::$ROLES),
        'rank' => $faker->randomElement(App\Domain\User::$RANKS),
        'assignment' => $faker->randomElement(App\Domain\User::$ASSIGNMENTS),
        'status' => $faker->randomElement(App\Domain\User::$STATUSES),
    ];
});

$factory->define(App\Domain\Article::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'text' => $faker->paragraph,
        'published' => $faker->dateTime,
        'access' => $faker->randomElement(App\Domain\User::$RANKS),
    ];
});

$factory->define(App\Domain\Meeting::class, function (Faker\Generator $faker) {
    return [
        'date' => $faker->dateTime,
        'location' => $faker->streetAddress,
        'text' => $faker->paragraph,
        'type' => $faker->randomElement(App\Domain\Meeting::$TYPES),
    ];
});

$factory->define(App\Domain\Lodge::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'orient' => $faker->city,
        'number' => $faker->unique()->randomNumber(2),
        'status' => $faker->randomElement(App\Domain\Lodge::$STATUSES),
    ];
});

$factory->define(App\Domain\RSVP::class, function (Faker\Generator $faker) {
    return [
        'answer' => $faker->randomElement(App\Domain\RSVP::$ANSWERS),
        'text' => $faker->paragraph,
    ];
});
