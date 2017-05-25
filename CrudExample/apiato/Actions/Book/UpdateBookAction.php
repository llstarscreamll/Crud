<?php

namespace App\Containers\Library\Actions\Book;

use App\Containers\Library\Tasks\Book\UpdateBookTask;
use App\Ship\Parents\Actions\Action;

/**
 * UpdateBookAction Class.
 * 
 * @author  [name] <[<email address>]>
 */
class UpdateBookAction extends Action
{
	public function run(int $id, array $input)
	{
		$book = $this->call(UpdateBookTask::class, [$id, $input]);

		return $book;
	}
}
