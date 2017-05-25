<?php

namespace App\Containers\Library\Actions\Book;

use App\Containers\Library\Tasks\Book\ListAndSearchBooksTask;
use App\Ship\Parents\Actions\Action;

/**
 * ListAndSearchBooksAction Class.
 * 
 * @author  [name] <[<email address>]>
 */
class ListAndSearchBooksAction extends Action
{
	public function run($input)
	{
		$book = $this->call(ListAndSearchBooksTask::class, [$input]);

		return $book;
	}
}
