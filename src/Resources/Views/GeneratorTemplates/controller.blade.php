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
use <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Http\Requests\<?= $gen->modelClassName()."Request" ?>;
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
    private $viewsDir = "{{$gen->viewsDirName()}}";
    
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // el usuario debe estar autenticado para acceder al controlador
        $this->middleware('auth');
        // el usuario debe tener permisos para acceder al controlador
        $this->middleware('<?= config("modules.CrudGenerator.config.permissions-middleware") ?>', ['except' => ['store', 'update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Http\Requests\<?= $gen->modelClassName()."Request" ?> $request
     *
     * @return Illuminate\Http\Response
     */
    public function index(<?= $gen->modelClassName()."Request" ?> $request)
    {
<?php if ($gen->areEnumFields($fields)) { ?>
        $<?= $gen->modelVariableName() ?> = new <?= $gen->modelClassName() ?>;
<?php } ?>
        $request = collect($request->all());
        // los datos para la vista
        $data = array();
@foreach($foreign_keys as $foreign)
@if(($child_table = explode(".", $foreign->foreign_key)) && ($parent_table = explode(".", $foreign->references)))
        $data['{{$child_table[1]}}_list'] = {{studly_case(str_singular($parent_table[0]))}}::pluck('name', 'id')->all();
<?php if ($request->get('use_x_editable', false)) { ?>
        $data['{{$child_table[1]}}_list_json'] = collect($data['{{$child_table[1]}}_list'])
            ->map(function ($item, $key) {
                return [$key => $item];
            })
            ->values()
            ->toJson();
<?php } ?>
@endif
@endforeach
@foreach($fields as $field)
@if($field->type == 'enum')
        $data['{{$field->name}}_list'] = ${{$gen->modelVariableName()}}->getEnumValuesArray('{{$field->name}}');
<?php if ($request->get('use_x_editable', false)) { ?>
        $data['{{$field->name}}_list_json'] = collect($data['{{$field->name}}_list'])
            ->map(function ($item, $key) {
                return [$key => $item];
            })
            ->values()
            ->toJson();
<?php } ?>
@endif
@endforeach
        $data['records'] = {{$gen->modelClassName()}}::findRequested($request)->paginate(15);
        
        return $this->view("index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Illuminate\Http\Response
     */
    public function create()
    {
<?php if ($gen->areEnumFields($fields)) { ?>
        $<?= $gen->modelVariableName() ?> = new <?= $gen->modelClassName() ?>;
<?php } ?>
        // los datos para la vista
        $data = array();
@foreach($foreign_keys as $foreign)
@if(($child_table = explode(".", $foreign->foreign_key)) && ($parent_table = explode(".", $foreign->references)))
        $data['{{$child_table[1]}}_list'] = {{studly_case(str_singular($parent_table[0]))}}::pluck('name', 'id')->all();
@endif
@endforeach
@foreach($fields as $field)
@if($field->type == 'enum')
        $data['{{$field->name}}_list'] = ${{$gen->modelVariableName()}}->getEnumValuesArray('{{$field->name}}');
@endif
@endforeach

        return $this->view("create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Http\Requests\<?= $gen->modelClassName()."Request" ?>  $reques
     *
     * @return Illuminate\Http\Response
     */
    public function store(<?= $gen->modelClassName()."Request" ?> $request)
    {
        {{$gen->modelClassName()}}::create($request->all());
        session()->flash('success', trans('{{$gen->getLangAccess()}}/messages.store_{{$gen->snakeCaseSingular()}}_success'));
        
        return redirect()->route('{{$gen->route().'.index'}}');
    }

    /**
     * Display the specified resource.
     *
@if ($hasSoftDelete = $gen->hasDeletedAtColumn($fields))
     * @param string $id
@else
     * @param \{{config('modules.CrudGenerator.config.parent-app-namespace')}}\Models\{{$gen->modelClassName()}} ${{$gen->modelVariableName()}}
@endif
     *
     * @return Illuminate\Http\Response
     */
    public function show({{ $hasSoftDelete ? 'int $id' : $gen->modelClassName().'$'.$gen->modelVariableName() }})
    {
        $<?= $gen->modelVariableName() ?> = <?= $gen->modelClassName().'::findOrFail($id)' ?>;

        // los datos para la vista
        $data = array();
        $data['{{$gen->modelVariableName()}}'] = {{ $hasSoftDelete ? '$'.$gen->modelVariableName() : '$'.$gen->modelVariableName() }};
@foreach($foreign_keys as $foreign)
@if(($child_table = explode(".", $foreign->foreign_key)) && ($parent_table = explode(".", $foreign->references)))
        $data['{{$child_table[1]}}_list'] = {{studly_case(str_singular($parent_table[0]))}}::where('id', $data['{{$gen->modelVariableName()}}']->{{$child_table[1]}})
            ->pluck('name', 'id')
            ->all();
@endif
@endforeach
@foreach($fields as $field)
@if($field->type == 'enum')
        $data['{{$field->name}}_list'] = ${{$gen->modelVariableName()}}->getEnumValuesArray('{{$field->name}}');
@endif
@endforeach

        return $this->view("show", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
@if ($hasSoftDelete = $gen->hasDeletedAtColumn($fields))
     * @param string $id
@else
     * @param \{{config('modules.CrudGenerator.config.parent-app-namespace')}}\Models\{{$gen->modelClassName()}} ${{$gen->modelVariableName()}}
@endif
     *
     * @return Illuminate\Http\Response
     */
    public function edit({{ $hasSoftDelete ? 'int $id' : $gen->modelClassName().'$'.$gen->modelVariableName() }})
    {
<?php if ($gen->areEnumFields($fields)) { ?>
        $<?= $gen->modelVariableName() ?> = new <?= $gen->modelClassName() ?>;
<?php } ?>
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
        $data['{{$field->name}}_list'] = ${{$gen->modelVariableName()}}->getEnumValuesArray('{{$field->name}}');
@endif
@endforeach

        return $this->view("edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Http\Requests\<?= $gen->modelClassName()."Request" ?> $request
@if ($hasSoftDelete = $gen->hasDeletedAtColumn($fields))
     * @param string $id
@else
     * @param \{{config('modules.CrudGenerator.config.parent-app-namespace')}}\Models\{{$gen->modelClassName()}} ${{$gen->modelVariableName()}}
@endif
     *
     * @return Illuminate\Http\Response
     */
    public function update(<?= $gen->modelClassName()."Request" ?> $request, {{ $hasSoftDelete ? 'int $id' : $gen->modelClassName().'$'.$gen->modelVariableName() }})
    {
@if ($hasSoftDelete)
        ${{ $gen->modelVariableName() }} = {{ $gen->modelClassName() }}::findOrFail($id);
@endif
<?php if ($request->get('use_x_editable', false)) { ?>
        if ($request->isXmlHttpRequest()) {
            $data = [$request->name  => $request->value];
            ${{$gen->modelVariableName()}}->update($data);

            return "Record updated";
        }

<?php } ?>
        ${{$gen->modelVariableName()}}->update($request->all());
        session()->flash(
            'success',
            trans('{{$gen->getLangAccess()}}/messages.update_{{$gen->snakeCaseSingular()}}_success')
        );

        return redirect()->route('{{$gen->route().'.index'}}');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Http\Requests\<?= $gen->modelClassName()."Request" ?> $request
@if ($hasSoftDelete = $gen->hasDeletedAtColumn($fields))
     * @param string $id
@else
     * @param \{{config('modules.CrudGenerator.config.parent-app-namespace')}}\Models\{{$gen->modelClassName()}} ${{$gen->modelVariableName()}}
@endif
     *
     * @return Illuminate\Http\Response
     */
    public function destroy(<?= $gen->modelClassName()."Request" ?> $request, {{ $hasSoftDelete ? 'int $id' : $gen->modelClassName().'$'.$gen->modelVariableName() }})
    {
        $id = $request->has('id') ? $request->get('id') : {!! $hasSoftDelete ? '$id' : '$'.$gen->modelVariableName().'->id' !!};

        {{$gen->modelClassName()}}::destroy($id);
        session()->flash(
            'success',
            trans_choice('{{$gen->getLangAccess()}}/messages.destroy_{{$gen->snakeCaseSingular()}}_success', count($id))
        );

        return redirect()->route('{{$gen->route().'.index'}}');
    }

@if($hasSoftDelete)
    /**
     * Restore the specified resource from storage.
     *
     * @param <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Http\Requests\<?= $gen->modelClassName()."Request" ?> $request
     * @param string $id
     *
     * @return Illuminate\Http\Response
     */
    public function restore(<?= $gen->modelClassName()."Request" ?> $request, int $id)
    {
        $id = $request->has('id') ? $request->get('id') : $id;

        {{$gen->modelClassName()}}::onlyTrashed()->whereIn('id', $id)->restore();
        session()->flash(
            'success',
            trans_choice('{{$gen->getLangAccess()}}/messages.restore_{{$gen->snakeCaseSingular()}}_success', count($id))
        );

        return redirect()->route('{{$gen->route().'.index'}}');
    }
@endif
    
    /**
     * Devuelve la vista con los respectivos datos.
     *
     * @param string $view
     * @param array  $data
     *
     * @return Illuminate\Http\Response
     */
    protected function view(string $view, array $data = [])
    {
        return view($this->viewsDir.".".$view, $data);
    }
}
