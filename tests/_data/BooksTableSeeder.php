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

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

/**
 * Clase BooksTableSeeder
 *
 * @author  Johan Alvarez <llstarscreamll@hotmail.com>
 */
class BooksTableSeeder extends Seeder
{
    public function run()
    {
        $data = array();
        $date = Carbon::now();
        $faker = Faker::create();

        $reasons = App\Models\Reason::all('id')->pluck('id')->toArray();
        $users = llstarscreamll\Core\Models\User::all('id')->pluck('id')->toArray();

        for ($i=0; $i < 10; $i++) { 
            $data[] = [
                'reason_id' => $faker->randomElement($reasons),
                'name' => $faker->sentence,
                'author' => $faker->sentence,
                'genre' => $faker->sentence,
                'stars' => $faker->randomNumber(),
                'published_year' => $date->toDateString(),
                'enabled' => $faker->boolean(60),
                'status' => $faker->randomElement(['setting_documents','waiting_confirmation','reviewing','approved']),
                'unlocking_word' => $faker->sentence,
                'synopsis' => $faker->text,
                'approved_at' => $date->toDateTimeString(),
                'approved_by' => $faker->randomElement($users),
                'approved_password' => $faker->sentence,
                'created_at' => $date->toDateTimeString(),
                'updated_at' => $date->toDateTimeString(),
                'deleted_at' => null,
            ];
        }

        \DB::table('books')->insert($data);
    }
}