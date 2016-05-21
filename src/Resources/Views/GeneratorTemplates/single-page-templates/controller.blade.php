<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
<?='<?php'?>

namespace {{config('llstarscreamll.CrudGenerator.config.parent-app-namespace')}}\Http\Controllers;

use {{config('llstarscreamll.CrudGenerator.config.parent-app-namespace')}}\Models\{{$gen->modelClassName()}};
use Illuminate\Http\Request;

use {{config('llstarscreamll.CrudGenerator.config.parent-app-namespace')}}\Http\Requests;
use {{config('llstarscreamll.CrudGenerator.config.parent-app-namespace')}}\Http\Controllers\Controller;

class {{$gen->controllerClassName()}} extends Controller
{
    /**
     * El directorio donde están las vistas.
     * @type String
     */
    public $viewDir = "{{$gen->viewsDirName()}}";
    
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // los datos de la vista
        $data = array();

        @foreach($foreign_keys as $foreign)
            @if(($child_table = explode(".", $foreign->foreign_key)) && ($parent_table = explode(".", $foreign->references)))
                $data['{{$child_table[1]}}_list'] = \App\{{ucwords(str_singular($parent_table[0]))}}::lists('name', 'id')->all();
            @endif
        @endforeach

        @foreach($fields as $field)
        @if($field->type == 'enum')
        $data['{{$field->name}}_list'] = {{$gen->modelClassName()}}::getEnumValues('{{$gen->table_name}}', '{{$field->name}}');
        @endif
        @endforeach
        $data['records'] = {{$gen->modelClassName()}}::findRequested();
        
        return $this->view( "index", $data );
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // los datos de la vista
        $data = array();

        @foreach($foreign_keys as $foreign)
            @if(($child_table = explode(".", $foreign->foreign_key)) && ($parent_table = explode(".", $foreign->references)))
                $data['{{$child_table[1]}}_list'] = \App\{{ucwords(str_singular($parent_table[0]))}}::lists('name', 'id')->all();
            @endif
        @endforeach

        @foreach($fields as $field)
        @if($field->type == 'enum')
        $data['{{$field->name}}_list'] = {{$gen->modelClassName()}}::getEnumValues('{{$gen->table_name}}', '{{$field->name}}');
        @endif
        @endforeach

        return $this->view("create", $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, {{$gen->modelClassName()}}::validationRules());

        {{$gen->modelClassName()}}::create($request->all());
        $request->session()->flash('success', trans('{{$gen->getLangAccess()}}/messages.create_{{$gen->snakeCaseSingular()}}_success'));
        
        return redirect()->route('{{$gen->route().'.index'}}');
    }

    /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, {{$gen->modelClassName()}} ${{$gen->modelVariableName()}})
    {
        // los datos de la vista
        $data = array();

        @foreach($foreign_keys as $foreign)
            @if(($child_table = explode(".", $foreign->foreign_key)) && ($parent_table = explode(".", $foreign->references)))
                $data['{{$child_table[1]}}_list'] = \App\{{ucwords(str_singular($parent_table[0]))}}::lists('name', 'id')->all();
            @endif
        @endforeach

        @foreach($fields as $field)
        @if($field->type == 'enum')
        $data['{{$field->name}}_list'] = {{$gen->modelClassName()}}::getEnumValues('{{$gen->table_name}}', '{{$field->name}}');
        @endif
        @endforeach
        $data['{{$gen->modelVariableName()}}'] = ${{$gen->modelVariableName()}};

        return $this->view("show", $data);
    }

    /**
     * Show the form for editing the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, {{$gen->modelClassName()}} ${{$gen->modelVariableName()}})
    {
        // los datos de la vista
        $data = array();

        @foreach($foreign_keys as $foreign)
            @if(($child_table = explode(".", $foreign->foreign_key)) && ($parent_table = explode(".", $foreign->references)))
                $data['{{$child_table[1]}}_list'] = \App\{{ucwords(str_singular($parent_table[0]))}}::lists('name', 'id')->all();
            @endif
        @endforeach

        @foreach($fields as $field)
        @if($field->type == 'enum')
        $data['{{$field->name}}_list'] = {{$gen->modelClassName()}}::getEnumValues('{{$gen->table_name}}', '{{$field->name}}');
        @endif
        @endforeach
        $data['{{$gen->modelVariableName()}}'] = ${{$gen->modelVariableName()}};

        return $this->view( "edit", $data );
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, {{$gen->modelClassName()}} ${{$gen->modelVariableName()}})
    {
        if( $request->isXmlHttpRequest() )
        {
            $data = [$request->name  => $request->value];
            $validator = \Validator::make( $data, {{$gen->modelClassName()}}::validationRules( $request->name ) );
            if($validator->fails())
                return response($validator->errors()->first( $request->name),403);
            ${{$gen->modelVariableName()}}->update($data);
            return "Record updated";
        }

        $this->validate($request, {{$gen->modelClassName()}}::validationRules());

        ${{$gen->modelVariableName()}}->update($request->all());
        $request->session()->flash('success', trans('{{$gen->getLangAccess()}}/messages.update_{{$gen->snakeCaseSingular()}}_success'));

        return redirect()->route('{{$gen->route().'.index'}}');
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, {{$gen->modelClassName()}} ${{$gen->modelVariableName()}})
    {
        $id = $request->has('id') ? $request->get('id') : ${{$gen->modelVariableName()}}->id;

        {{$gen->modelClassName()}}::destroy($id)
            ? $request->session()->flash('success', trans_choice('{{$gen->getLangAccess()}}/messages.destroy_{{$gen->snakeCaseSingular()}}_success', count($id)))
            : $request->session()->flash('error', trans_choice('{{$gen->getLangAccess()}}/messages.destroy_{{$gen->snakeCaseSingular()}}_error', count($id)));

        return redirect()->route('{{$gen->route().'.index'}}');
    }
    
    /**
     * Devuelve la vista con los respectivos datos.
     * @param  string $view
     * @param  string $data
     * @return \Illuminate\Http\Response
     */
    protected function view($view, $data = [])
    {
        return view($this->viewDir.".".$view, $data);
    }

}
