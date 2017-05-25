<?php

namespace App\Containers\Library\Actions\Book;

use App\Containers\Library\Tasks\Book\RestoreBookTask;
use App\Ship\Parents\Actions\Action;

/**
 * RestoreBookAction Class.
 * 
 * @author  [name] <[<email address>]>
 */
class RestoreBookAction extends Action
{
	public function run(int $id)
	{
		$book = $this->call(RestoreBookTask::class, [$id]);

		return $book;
	}
}
