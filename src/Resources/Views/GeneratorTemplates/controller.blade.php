<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
/* @var $foreign_keys [] */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


namespace {{config('modules.CrudGenerator.config.parent-app-namespace')}}\Http\Controllers;

use Illuminate\Http\Request;
use {{config('modules.CrudGenerator.config.parent-app-namespace')}}\Models\{{$gen->modelClassName()}};
use {{config('modules.CrudGenerator.config.parent-app-namespace')}}\Http\Controllers\Controller;
@foreach($foreign_keys as $foreign)
@if(($class = $gen->getForeignKeyModelNamespace($foreign, $fields)) !== false)
use {{$class}};
@endif
@endforeach

/**
 * Clase {{$gen->controllerClassName()}}
 *
 * @author {{ config('modules.CrudGenerator.config.author') }} <{{ config('modules.CrudGenerator.config.author_email') }}>
 */
class {{$gen->controllerClassName()}} extends Controller
{
    /**
     * El directorio donde están las vistas.
     *
     * @var String
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
        //$this->middleware('checkPermissions', ['except' => ['store', 'update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // los datos para la vista
        $data = array();

@foreach($foreign_keys as $foreign)
@if(($child_table = explode(".", $foreign->foreign_key)) && ($parent_table = explode(".", $foreign->references)))
        $data['{{$child_table[1]}}_list'] = {{studly_case(str_singular($parent_table[0]))}}::pluck('name', 'id')->all();
        $data['{{$child_table[1]}}_list_json'] = collect($data['{{$child_table[1]}}_list'])
            ->map(function ($item, $key) { return [$key => $item];})
            ->values()
            ->toJson();

@endif
@endforeach
@foreach($fields as $field)
@if($field->type == 'enum')
        $data['{{$field->name}}_list'] = {{$gen->modelClassName()}}::getEnumValuesArray('{{$gen->table_name}}', '{{$field->name}}');
        $data['{{$field->name}}_list_json'] = collect($data['{{$field->name}}_list'])
            ->map(function ($item, $key) { return [$key => $item];})
            ->values()
            ->toJson();

@endif
@endforeach
        $data['records'] = {{$gen->modelClassName()}}::findRequested($request);
        
        return $this->view("index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // los datos para la vista
        $data = array();
@foreach($foreign_keys as $foreign)
@if(($child_table = explode(".", $foreign->foreign_key)) && ($parent_table = explode(".", $foreign->references)))
        $data['{{$child_table[1]}}_list'] = {{studly_case(str_singular($parent_table[0]))}}::pluck('name', 'id')->all();

@endif
@endforeach
@foreach($fields as $field)
@if($field->type == 'enum')
        $data['{{$field->name}}_list'] = {{$gen->modelClassName()}}::getEnumValuesArray('{{$gen->table_name}}', '{{$field->name}}');

@endif
@endforeach

        return $this->view("create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $reques
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, {{$gen->modelClassName()}}::validationRules(null, $request), [], trans('{{$gen->getLangAccess()}}/validation.attributes'));

        {{$gen->modelClassName()}}::create($request->all());
        $request->session()->flash('success', trans('{{$gen->getLangAccess()}}/messages.create_{{$gen->snakeCaseSingular()}}_success'));
        
        return redirect()->route('{{$gen->route().'.index'}}');
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
@if ($hasSoftDelete = $gen->hasDeletedAtColumn($fields))
     * @param string $id
@else
     * @param \{{config('modules.CrudGenerator.config.parent-app-namespace')}}\Models\{{$gen->modelClassName()}} ${{$gen->modelVariableName()}}
@endif
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, {{ $hasSoftDelete ? '$id' : $gen->modelClassName().'$'.$gen->modelVariableName() }})
    {
        // los datos para la vista
        $data = array();
        $data['{{$gen->modelVariableName()}}'] = {{ $hasSoftDelete ? $gen->modelClassName().'::findOrFail($id)' : '$'.$gen->modelVariableName() }};

@foreach($foreign_keys as $foreign)
@if(($child_table = explode(".", $foreign->foreign_key)) && ($parent_table = explode(".", $foreign->references)))
        $data['{{$child_table[1]}}_list'] = (${{strtolower(str_singular($parent_table[0]))}} = {{studly_case(str_singular($parent_table[0]))}}::where('id', $data['{{$gen->modelVariableName()}}']->{{$child_table[1]}})->first())
            ? ${{strtolower(str_singular($parent_table[0]))}}->pluck('name', 'id')->all()
            : [];

@endif
@endforeach
@foreach($fields as $field)
@if($field->type == 'enum')
        $data['{{$field->name}}_list'] = {{$gen->modelClassName()}}::getEnumValuesArray('{{$gen->table_name}}', '{{$field->name}}');
        
@endif
@endforeach
        return $this->view("show", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
@if ($hasSoftDelete = $gen->hasDeletedAtColumn($fields))
     * @param string $id
@else
     * @param \{{config('modules.CrudGenerator.config.parent-app-namespace')}}\Models\{{$gen->modelClassName()}} ${{$gen->modelVariableName()}}
@endif
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, {{ $hasSoftDelete ? '$id' : $gen->modelClassName().'$'.$gen->modelVariableName() }})
    {
        // los datos para la vista
        $data = array();
        $data['{{$gen->modelVariableName()}}'] = {{ $hasSoftDelete ? $gen->modelClassName().'::findOrFail($id)' : '$'.$gen->modelVariableName() }};

@foreach($foreign_keys as $foreign)
@if(($child_table = explode(".", $foreign->foreign_key)) && ($parent_table = explode(".", $foreign->references)))
        $data['{{$child_table[1]}}_list'] = {{studly_case(str_singular($parent_table[0]))}}::pluck('name', 'id')->all();

@endif
@endforeach
@foreach($fields as $field)
@if($field->type == 'enum')
        $data['{{$field->name}}_list'] = {{$gen->modelClassName()}}::getEnumValuesArray('{{$gen->table_name}}', '{{$field->name}}');

@endif
@endforeach
        return $this->view("edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
@if ($hasSoftDelete = $gen->hasDeletedAtColumn($fields))
     * @param string $id
@else
     * @param \{{config('modules.CrudGenerator.config.parent-app-namespace')}}\Models\{{$gen->modelClassName()}} ${{$gen->modelVariableName()}}
@endif
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, {{ $hasSoftDelete ? '$id' : $gen->modelClassName().'$'.$gen->modelVariableName() }})
    {
@if ($hasSoftDelete)
        ${{ $gen->modelVariableName() }} = {{ $gen->modelClassName() }}::findOrFail($id);

@endif
        if( $request->isXmlHttpRequest() )
        {
            $data = [$request->name  => $request->value];
            $validator = \Validator::make($data, {{$gen->modelClassName()}}::validationRules($request->name, $request, 'update'), [], trans('{{$gen->getLangAccess()}}/validation.attributes'));
            
            if($validator->fails()) {
                return response($validator->errors()->first( $request->name),403);
            }

            ${{$gen->modelVariableName()}}->update($data);

            return "Record updated";
        }

        $this->validate($request, {{$gen->modelClassName()}}::validationRules(null, $request, 'update'), [], trans('{{$gen->getLangAccess()}}/validation.attributes'));

        ${{$gen->modelVariableName()}}->update($request->all());
        $request->session()->flash('success', trans('{{$gen->getLangAccess()}}/messages.update_{{$gen->snakeCaseSingular()}}_success'));

        return redirect()->route('{{$gen->route().'.index'}}');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
@if ($hasSoftDelete = $gen->hasDeletedAtColumn($fields))
     * @param string $id
@else
     * @param \{{config('modules.CrudGenerator.config.parent-app-namespace')}}\Models\{{$gen->modelClassName()}} ${{$gen->modelVariableName()}}
@endif
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, {{ $hasSoftDelete ? '$id' : $gen->modelClassName().'$'.$gen->modelVariableName() }})
    {
        $id = $request->has('id') ? $request->get('id') : {!! $hasSoftDelete ? '$id' : '$'.$gen->modelVariableName().'->id' !!};

        {{$gen->modelClassName()}}::destroy($id)
            ? $request->session()->flash('success', trans_choice('{{$gen->getLangAccess()}}/messages.destroy_{{$gen->snakeCaseSingular()}}_success', count($id)))
            : $request->session()->flash('error', trans_choice('{{$gen->getLangAccess()}}/messages.destroy_{{$gen->snakeCaseSingular()}}_error', count($id)));

        return redirect()->route('{{$gen->route().'.index'}}');
    }

@if($hasSoftDelete)
    /**
     * Restore the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id
     *
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $id = $request->has('id') ? $request->get('id') : $id;

        {{$gen->modelClassName()}}::onlyTrashed()->whereIn('id', $id)->restore()
            ? $request->session()->flash('success', trans_choice('{{$gen->getLangAccess()}}/messages.restore_{{$gen->snakeCaseSingular()}}_success', count($id)))
            : $request->session()->flash('error', trans_choice('{{$gen->getLangAccess()}}/messages.restore_{{$gen->snakeCaseSingular()}}_error', count($id)));

        return redirect()->route('{{$gen->route().'.index'}}');
    }
@endif
    
    /**
     * Devuelve la vista con los respectivos datos.
     *
     * @param string $view
     * @param string $data
     *
     * @return \Illuminate\Http\Response
     */
    protected function view($view, $data = [])
    {
        return view($this->viewDir.".".$view, $data);
    }
}
