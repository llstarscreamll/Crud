<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use llstarscreamll\Core\Models\User;
use App\Models\Reason;

class BookController extends Controller
{
    /**
     * El directorio donde están las vistas.
     * @type  String
     */
    public $viewDir = "books";
    
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // el usuario debe estar autenticado para acceder al controlador
        $this->middleware('auth');
        // el usuario debe tener permisos para acceder al controlador
        // $this->middleware('checkPermissions', ['except' => ['store', 'update']]);
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // los datos para la vista
        $data = array();

        $data['approved_by_list'] = User::pluck('name', 'id')->all();
        $data['approved_by_list_json'] = collect($data['approved_by_list'])
            ->map(function ($item, $key) { return [$key => $item];})
            ->values()
            ->toJson();

        $data['reason_id_list'] = Reason::pluck('name', 'id')->all();
        $data['reason_id_list_json'] = collect($data['reason_id_list'])
            ->map(function ($item, $key) { return [$key => $item];})
            ->values()
            ->toJson();

        $data['status_list'] = Book::getEnumValuesArray('books', 'status');
        $data['status_list_json'] = collect($data['status_list'])
            ->map(function ($item, $key) { return [$key => $item];})
            ->values()
            ->toJson();

        $data['records'] = Book::findRequested($request);
        
        return $this->view("index", $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        // los datos para la vista
        $data = array();
        $data['approved_by_list'] = User::pluck('name', 'id')->all();

        $data['reason_id_list'] = Reason::pluck('name', 'id')->all();

        $data['status_list'] = Book::getEnumValuesArray('books', 'status');


        return $this->view("create", $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Book::validationRules(null, $request), [], trans('book/validation.attributes'));

        Book::create($request->all());
        $request->session()->flash('success', trans('book/messages.create_book_success'));
        
        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request $request
     * @param  string $id
     * @return  \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // los datos para la vista
        $data = array();
        $data['book'] = Book::findOrFail($id);

        $data['approved_by_list'] = ($user = User::where('id', $data['book']->approved_by)->first())
            ? $user->pluck('name', 'id')->all()
            : [];

        $data['reason_id_list'] = ($reason = Reason::where('id', $data['book']->reason_id)->first())
            ? $reason->pluck('name', 'id')->all()
            : [];

        $data['status_list'] = Book::getEnumValuesArray('books', 'status');
        
        return $this->view("show", $data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Illuminate\Http\Request $request
     * @param  string $id
     * @return  \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // los datos para la vista
        $data = array();
        $data['book'] = Book::findOrFail($id);

        $data['approved_by_list'] = User::pluck('name', 'id')->all();

        $data['reason_id_list'] = Reason::pluck('name', 'id')->all();

        $data['status_list'] = Book::getEnumValuesArray('books', 'status');

        return $this->view("edit", $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @param  string $id
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        if( $request->isXmlHttpRequest() )
        {
            $data = [$request->name  => $request->value];
            $validator = \Validator::make($data, Book::validationRules($request->name, $request, 'update'), [], trans('book/validation.attributes'));
            
            if($validator->fails()) {
                return response($validator->errors()->first( $request->name),403);
            }

            $book->update($data);

            return "Record updated";
        }

        $this->validate($request, Book::validationRules(null, $request, 'update'), [], trans('book/validation.attributes'));

        $book->update($request->all());
        $request->session()->flash('success', trans('book/messages.update_book_success'));

        return redirect()->route('books.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request $request
     * @param  string $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $id = $request->has('id') ? $request->get('id') : $id;

        Book::destroy($id)
            ? $request->session()->flash('success', trans_choice('book/messages.destroy_book_success', count($id)))
            : $request->session()->flash('error', trans_choice('book/messages.destroy_book_error', count($id)));

        return redirect()->route('books.index');
    }

    /**
     * Restore the specified resource from storage.
     * @param  \Illuminate\Http\Request $request
     * @param  string $id
     * @return  \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $id = $request->has('id') ? $request->get('id') : $id;

        Book::onlyTrashed()->whereIn('id', $id)->restore()
            ? $request->session()->flash('success', trans_choice('book/messages.restore_book_success', count($id)))
            : $request->session()->flash('error', trans_choice('book/messages.restore_book_error', count($id)));

        return redirect()->route('books.index');
    }
    
    /**
     * Devuelve la vista con los respectivos datos.
     * @param  string $view
     * @param  string $data
     * @return  \Illuminate\Http\Response
     */
    protected function view($view, $data = [])
    {
        return view($this->viewDir.".".$view, $data);
    }

}
