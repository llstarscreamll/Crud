<?php

namespace App\Containers\Library\Actions\Book;

use App\Containers\Library\Tasks\Book\CreateBookTask;
use App\Ship\Parents\Actions\Action;

/**
 * CreateBookAction Class.
 * 
 * @author  [name] <[<email address>]>
 */
class CreateBookAction extends Action
{
	public function run(array $input)
	{
		$book = $this->call(CreateBookTask::class, [$input]);

		return $book;
	}
}
