<?php

namespace App\Containers\Library\Tasks\Book;

use App\Containers\Library\Data\Repositories\BookRepository;
use App\Containers\Library\Exceptions\BookCreationFailedException;
use App\Ship\Parents\Tasks\Task;

/**
 * GetBookTask Class.
 * 
 * @author  [name] <[<email address>]>
 */
class GetBookTask extends Task
{
	public function run(int $id) {
        $book = app(BookRepository::class)->makeModel()->withTrashed()->find($id);
        return $book;
	}
}
