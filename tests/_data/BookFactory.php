<?php

/**
 * Este archivo es parte de Books.
 * (c) Johan Alvarez <llstarscreamll@hotmail.com>
 * Licensed under The MIT License (MIT).
 *
 * @package    Books
 * @version    0.1
 * @author     Johan Alvarez
 * @license    The MIT License (MIT)
 * @copyright  (c) 2015-2016, Johan Alvarez <llstarscreamll@hotmail.com>
 * @link       https://github.com/llstarscreamll
 */

$factory->define(App\Models\Book::class, function (Faker\Generator $faker) {
    $reasons = App\Models\Reason::all('id')->pluck('id')->toArray();
    $users = llstarscreamll\Core\Models\User::all('id')->pluck('id')->toArray();

    return [
        'reason_id' => $faker->randomElement($reasons),
        'name' => $faker->sentence,
        'author' => $faker->sentence,
        'genre' => $faker->sentence,
        'stars' => $faker->randomNumber(),
        'published_year' => $faker->date('Y-m-d'),
        'enabled' => $faker->boolean(60),
        'status' => $faker->randomElement(['setting_documents','waiting_confirmation','reviewing','approved']),
        'unlocking_word' => $faker->sentence,
        'synopsis' => $faker->text,
        'approved_at' => $faker->date('Y-m-d H:i:s'),
        'approved_by' => $faker->randomElement($users),
        'approved_password' => $faker->sentence,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => null,
    ];
});
