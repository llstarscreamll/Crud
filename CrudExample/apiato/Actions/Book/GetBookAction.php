<?php

namespace App\Containers\Library\Actions\Book;

use App\Containers\Library\Tasks\Book\GetBookTask;
use App\Ship\Parents\Actions\Action;

/**
 * GetBookAction Class.
 * 
 * @author  [name] <[<email address>]>
 */
class GetBookAction extends Action
{
	public function run(int $id)
	{
		$book = $this->call(GetBookTask::class, [$id]);

		return $book;
	}
}
