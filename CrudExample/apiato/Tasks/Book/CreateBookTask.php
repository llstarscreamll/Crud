<?php

namespace App\Containers\Library\Tasks\Book;

use App\Containers\Library\Data\Repositories\BookRepository;
use App\Containers\Library\Exceptions\BookCreationFailedException;
use App\Ship\Parents\Tasks\Task;

/**
 * CreateBookTask Class.
 * 
 * @author  [name] <[<email address>]>
 */
class CreateBookTask extends Task
{
	public function run(array $input) {
		try {
            $book = app(BookRepository::class)->create($input);
        } catch (Exception $e) {
            throw (new BookCreationFailedException())->debug($e);
        }

        return $book;
	}
}
