<?php

namespace App\Containers\Library\Tasks\Book;

use App\Containers\Library\Data\Repositories\BookRepository;
use App\Ship\Parents\Tasks\Task;

/**
 * RestoreBookTask Class.
 * 
 * @author  [name] <[<email address>]>
 */
class RestoreBookTask extends Task
{
	public function run(int $id) {
        $book = app(BookRepository::class)->restore($id);
        return $book;
	}
}
