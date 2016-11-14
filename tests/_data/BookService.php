<?php

/**
 * Este archivo es parte de Books.
 * (c) Johan Alvarez <llstarscreamll@hotmail.com>
 * Licensed under The MIT License (MIT).
 *
 * @package    Books
 * @version    0.1
 * @author     Johan Alvarez
 * @license    The MIT License (MIT)
 * @copyright  (c) 2015-2016, Johan Alvarez <llstarscreamll@hotmail.com>
 * @link       https://github.com/llstarscreamll
 */

namespace App\Services;

use App\Http\Requests\BookRequest;
use App\Repositories\Contracts\BookRepository;
use App\Models\Book;
use llstarscreamll\Core\Contracts\UserRepository;
use App\Repositories\Contracts\ReasonRepository;
use Illuminate\Support\Collection;

/**
 * Clase BookService
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class BookService
{
    /**
     * @var App\Repositories\Contracts\BookRepository
     */
    private $bookRepository;
    
    /**
     * @var llstarscreamll\Core\Contracts\UserRepository
     */
    private $userRepository;
    
    /**
     * @var App\Repositories\Contracts\ReasonRepository
     */
    private $reasonRepository;

    /**
     * Las columnas predeterminadas a mostrar en la tabla del Index.
     *
     * @var array
     */
    private $defaultSelectedtableColumns = [
        'id',
        'reason_id',
        'name',
        'author',
        'approved_at',
        'created_at',
    ];

    /**
     * Las columnas o atributos que deben ser consultados de la base de datos,
     * así el usuario no lo especifique.
     *
     * @var array
     */
    private $forceQueryColumns = [
        'id',
        'deleted_at'
    ];

    /**
     * Crea nueva instancia del servicio.
     *
     * @param App\Repositories\Contracts\BookRepository $bookRepository
     * @param llstarscreamll\Core\Contracts\UserRepository $userRepository
     * @param App\Repositories\Contracts\ReasonRepository $reasonRepository
     */
    public function __construct(BookRepository $bookRepository, UserRepository $userRepository, ReasonRepository $reasonRepository)
    {
        $this->bookRepository = $bookRepository;
        $this->userRepository = $userRepository;
        $this->reasonRepository = $reasonRepository;
    }

    /**
     * Obtiene datos de consulta predeterminada o lo que indique el usuario de
     * la entidad para la vista Index.
     *
     * @param  App\Http\Requests\BookRequest  $request
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function indexSearch(BookRequest $request)
    {
        $search = collect($request->get('search'));
        return $this->bookRepository
            ->getRequested($search, $this->getQueryColumns($search));
    }

    /**
     * Obtienen array de columnas a consultar en la base de datos para la tabla
     * del index.
     *
     * @param  Illuminate\Support\Collection $search
     *
     * @return array
     */
    private function getQueryColumns(Collection $search)
    {
        return array_merge(
            $search->get('table_columns', $this->defaultSelectedtableColumns),
            $this->forceQueryColumns
        );
    }

    /**
     * Obtiene los datos para la vista Index.
     *
     * @param  App\Http\Requests\BookRequest  $request
     *
     * @return array
     */
    public function getIndexTableData(BookRequest $request)
    {
        $search = collect($request->get('search'));

        $data = [];
        $data += $this->getCreateFormData();
        $data['selectedTableColumns'] = $search->get(
            'table_columns',
            $this->defaultSelectedtableColumns
        );

        return $data;
    }

    /**
     * Obtiene los datos para la vista de creación.
     *
     * @return array
     */
    public function getCreateFormData()
    {
        $data = [];
        $data['approved_by_list'] = $this->userRepository->getSelectList();
        $data['reason_id_list'] = $this->reasonRepository->getSelectList();
        $data['status_list'] = $this->bookRepository->getEnumFieldSelectList('status');
    
        return $data;
    }

    /**
     * Obtiene los datos para la vista de detalles.
     *
     * @param  int  $id
     *
     * @return array
     */
    public function getShowFormData(int $id)
    {
        $data = array();
        $book = $this->bookRepository->find($id);
        $data['book'] = $book;
        $data['approved_by_list'] = $this->userRepository->getSelectList(
            'id',
            'name',
            (array) $book->approved_by
        );
        $data['reason_id_list'] = $this->reasonRepository->getSelectList(
            'id',
            'name',
            (array) $book->reason_id
        );
        $data['status_list'] = $book->getEnumValuesArray('status');
    
        return $data;
    }

    /**
     * Obtiene los datos para la vista de edición.
     *
     * @param  int  $id
     *
     * @return array
     */
    public function getEditFormData(int $id)
    {
        $data = array();
        $data['book'] = $this->bookRepository->find($id);
        $data += $this->getCreateFormData();
        
        return $data;
    }

    /**
     * Guarda en base de datos nuevo registro de Libro.
     *
     * @param  App\Http\Requests\BookRequest  $request
     *
     * @return App\Models\Book
     */
    public function store(BookRequest $request)
    {
        $input = null_empty_fields($request->all());
        $book = $this->bookRepository->create($input);
        session()->flash('success', trans('book.store_book_success'));

        return $book;
    }

    /**
     * Realiza actualización de Libro.
     *
     * @param  int  $id
     * @param  App\Http\Requests\BookRequest  $request
     *
     * @return  App\Models\Book
     */
    public function update(int $id, BookRequest $request)
    {
        $input = null_empty_fields($request->all());
        $book = $this->bookRepository->update($input, $id);
        session()->flash(
            'success',
            trans('book.update_book_success')
        );

        return $book;
    }

    /**
     * Realiza acción de mover a papelera registro de Libro.
     *
     * @param  int  $id
     * @param  App\Http\Requests\BookRequest  $request
     */
    public function destroy(int $id, BookRequest $request)
    {
        $id = $request->has('id') ? $request->get('id') : $id;

        $this->bookRepository->destroy($id);
        session()->flash(
            'success',
            trans_choice('book.destroy_book_success', count($id))
        );
    }

    /**
     * Realiza restauración de Libro.
     *
     * @param  int  $id
     * @param  App\Http\Requests\BookRequest  $request
     */
    public function restore(int $id, BookRequest $request)
    {
        $id = $request->has('id') ? $request->get('id') : $id;

        $this->bookRepository->restore($id);
        session()->flash(
            'success',
            trans_choice('book.restore_book_success', count($id))
        );
    }
}
