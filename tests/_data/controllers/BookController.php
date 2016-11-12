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

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookService;
use App\Http\Requests\BookRequest;
use App\Http\Controllers\Controller;

/**
 * Clase BookController
 *
 * @author  Johan Alvarez <llstarscreamll@hotmail.com>
 */
class BookController extends Controller
{
    /**
     * El directorio donde están las vistas.
     *
     * @var  String
     */
    private $viewsDir = "books";
    
    /**
     * @var  App\Services\BookService
     */
    private $bookService;
    
    /**
     * Create a new controller instance.
     */
    public function __construct(BookService $bookService)
    {
        // el usuario debe estar autenticado para acceder al controlador
        $this->middleware('auth');
        // el usuario debe tener permisos para acceder al controlador
        $this->middleware('permission', ['except' => ['store', 'update']]);
        $this->bookService = $bookService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\BookRequest $request
     *
     * @return  Illuminate\Http\Response
     */
    public function index(BookRequest $request)
    {
        $data = $this->bookService->getIndexTableData($request);
        $data['records'] = $this->bookService->indexSearch($request);

        return $this->view('index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->bookService->getCreateFormData();
        return $this->view('create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    App\Http\Requests\BookRequest  $request
     *
     * @return  Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        $this->bookService->store($request);
        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return  Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $data = $this->bookService->getShowFormData($id);
        return $this->view('show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return  Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $data = $this->bookService->getEditFormData($id);
        return $this->view('edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param  App\Http\Requests\BookRequest $request
     *
     * @return  Illuminate\Http\Response
     */
    public function update(int $id, BookRequest $request)
    {
        $this->bookService->update($id, $request);
        
        if ($request->isXmlHttpRequest()) {
            return response('ok!!', 204);
        }

        return redirect()->route('books.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param  App\Http\Requests\BookRequest $request
     *
     * @return  Illuminate\Http\Response
     */
    public function destroy(int $id, BookRequest $request)
    {
        $this->bookService->destroy($id, $request);
        return redirect()->route('books.index');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int $id
     * @param  App\Http\Requests\BookRequest $request
     *
     * @return  Illuminate\Http\Response
     */
    public function restore(int $id, BookRequest $request)
    {
        $this->bookService->restore($id, $request);
        return redirect()->route('books.index');
    }
    
    /**
     * Devuelve la vista con los respectivos datos.
     *
     * @param  string $view
     * @param  array  $data
     *
     * @return  Illuminate\Http\Response
     */
    protected function view(string $view, array $data = [])
    {
        return view($this->viewsDir.'.'.$view, $data);
    }
}
