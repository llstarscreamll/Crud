<?php

namespace App\Containers\Library\Actions\Book;

use App\Containers\Library\Tasks\Book\DeleteBookTask;
use App\Ship\Parents\Actions\Action;

/**
 * DeleteBookAction Class.
 * 
 * @author  [name] <[<email address>]>
 */
class DeleteBookAction extends Action
{
	public function run(int $id)
	{
		$book = $this->call(DeleteBookTask::class, [$id]);

		return $book;
	}
}
