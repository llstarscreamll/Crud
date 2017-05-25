<?php

namespace App\Containers\Library\Actions\Book;

use App\Containers\Library\Data\Repositories\BookRepository;
use App\Ship\Parents\Actions\Action;
use Fractal;

/**
 * SelectListFromBookAction Class.
 * 
 * @author  [name] <[<email address>]>
 */
class SelectListFromBookAction extends Action
{
	public function run()
	{
		return app(BookRepository::class)->selectList();
	}
}
