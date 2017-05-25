<?php

namespace App\Containers\Library\UI\API\Controllers;

use App\Containers\Library\Actions\Book\CreateBookAction;
use App\Containers\Library\Actions\Book\DeleteBookAction;
use App\Containers\Library\Actions\Book\GetBookAction;
use App\Containers\Library\Actions\Book\ListAndSearchBooksAction;
use App\Containers\Library\Actions\Book\RestoreBookAction;
use App\Containers\Library\Actions\Book\SelectListFromBookAction;
use App\Containers\Library\Actions\Book\UpdateBookAction;
use App\Containers\Library\UI\API\Requests\Book\CreateBookRequest;
use App\Containers\Library\UI\API\Requests\Book\DeleteBookRequest;
use App\Containers\Library\UI\API\Requests\Book\GetBookRequest;
use App\Containers\Library\UI\API\Requests\Book\ListAndSearchBooksRequest;
use App\Containers\Library\UI\API\Requests\Book\RestoreBookRequest;
use App\Containers\Library\UI\API\Requests\Book\SelectListFromBookRequest;
use App\Containers\Library\UI\API\Requests\Book\UpdateBookRequest;
use App\Containers\Library\UI\API\Transformers\BookTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\Request;

/**
 * BookController Class.
 * 
 * @author  [name] <[<email address>]>
 */
class BookController extends ApiController
{
	/**
	 * Returns the array entity form model.
	 *
	 * @param    Request $request
	 * @return  Illuminate\Http\Response
	 */
	public function formModel(Request $request)
	{
		$model = config('book-form-model');

		if (empty($model)) {
            return abort(404, 'Form Model Not Found.');
        }

		return $model;
	}

	/**
	 * Returns list of all records on DB with only id and name columns, mainly
	 * to be used on select dropdowns.
	 *
	 * @param  SelectListFromBookRequest $request
	 * @return  Illuminate\Http\Response
	 */
	public function selectListFromBook(SelectListFromBookRequest $request)
	{
		$data = $this->call(SelectListFromBookAction::class);

		return $data;
	}

	/**
	 * List and search resources from storage.
	 *
	 * @param  ListAndSearchBooksRequest $request
	 * @return  Illuminate\Http\Response
	 */
	public function listAndSearchBooks(ListAndSearchBooksRequest $request)
	{
		$books = $this->call(ListAndSearchBooksAction::class, [$request]);
		return $this->transform($books, new BookTransformer());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  CreateBookRequest $request
	 * @return  Illuminate\Http\Response
	 */
	public function createBook(CreateBookRequest $request)
	{
		$book = $this->call(CreateBookAction::class, [$request->all()]);
		return $this->transform($book, new BookTransformer());
	}

	/**
	 * Returns the specified resource.
	 *
	 * @param  GetBookRequest $request
	 * @return  Illuminate\Http\Response
	 */
	public function getBook(GetBookRequest $request)
	{
		$book = $this->call(GetBookAction::class, [$request->id]);
		return $this->transform($book, new BookTransformer());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  UpdateBookRequest $request
	 * @return  Illuminate\Http\Response
	 */
	public function updateBook(UpdateBookRequest $request)
	{
		$book = $this->call(UpdateBookAction::class, [$request->id, $request->all()]);
		return $this->transform($book, new BookTransformer());
	}

	/**
	 * SoftDelete the specified resource from storage.
	 *
	 * @param  DeleteBookRequest $request
	 * @return  Illuminate\Http\Response
	 */
	public function deleteBook(DeleteBookRequest $request)
	{
		$book = $this->call(DeleteBookAction::class, [$request->id]);
		return $this->accepted('Book Deleted Successfully.');
	}

	/**
	 * Restore the specified softDeleted resource from storage.
	 *
	 * @param  RestoreBookRequest $request
	 * @return  Illuminate\Http\Response
	 */
	public function restoreBook(RestoreBookRequest $request)
	{
		$book = $this->call(RestoreBookAction::class, [$request->id]);
		return $this->transform($book, new BookTransformer());
	}
}
