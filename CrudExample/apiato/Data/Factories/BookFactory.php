<?php

use App\Containers\Reason\Models\Reason;
use App\Containers\User\Models\User;
use App\Containers\Library\Models\Book;

$factory->define(Book::class, function (Faker\Generator $faker) {
    $reasons = factory(Reason::class, 2)->create()->pluck('id')->toArray();
    $users = factory(User::class, 2)->create()->pluck('id')->toArray();

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
