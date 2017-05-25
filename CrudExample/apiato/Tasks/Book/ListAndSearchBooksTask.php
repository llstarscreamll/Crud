<?php

namespace App\Containers\Library\Tasks\Book;

use App\Containers\Library\Data\Repositories\BookRepository;
use App\Containers\Library\Data\Criterias\Book\AdvancedBookSearchCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Ship\Parents\Tasks\Task;

/**
 * ListAndSearchBooksTask Class.
 * 
 * @author  [name] <[<email address>]>
 */
class ListAndSearchBooksTask extends Task
{
	public function run($input) {
		$bookRepository = app(BookRepository::class);

		if ($input->get('advanced_search', false)) {
			$bookRepository
				->popCriteria(RequestCriteria::class)
				->pushCriteria(new AdvancedBookSearchCriteria($input));
		}
        
        $books = $bookRepository->paginate();
        
        return $books;
	}
}
