<?php

namespace App\Containers\Library\Tasks\Book;

use App\Containers\Library\Data\Repositories\BookRepository;
use App\Containers\Library\Exceptions\BookCreationFailedException;
use App\Ship\Parents\Tasks\Task;

/**
 * UpdateBookTask Class.
 * 
 * @author  [name] <[<email address>]>
 */
class UpdateBookTask extends Task
{
	public function run(int $id, array $input) {
		$book = app(BookRepository::class)->update($input, $id);

        return $book;
	}
}
