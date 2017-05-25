<?php

namespace App\Containers\Library\Tasks\Book;

use App\Containers\Library\Data\Repositories\BookRepository;
use App\Ship\Parents\Tasks\Task;

/**
 * DeleteBookTask Class.
 * 
 * @author  [name] <[<email address>]>
 */
class DeleteBookTask extends Task
{
	public function run(int $id) {
        $book = app(BookRepository::class)->delete($id);
        return $book;
	}
}
