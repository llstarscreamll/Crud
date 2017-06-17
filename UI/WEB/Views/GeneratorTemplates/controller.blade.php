<?php
/* @var $crud App\Containers\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
/* @var $foreign_keys [] */
?>
<?='<?php'?>


<?= $crud->getClassCopyRightDocBlock() ?>


namespace <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Controllers;

use Illuminate\Http\Request;
use <?= config('modules.crud.config.parent-app-namespace') ?>\Services\<?= $crud->modelClassName() ?>Service;
use <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Requests\<?= $crud->modelClassName()."Request" ?>;
use <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Controllers\Controller;

/**
 * Clase <?= $crud->controllerClassName()."\n" ?>
 *
 * @author <?= config('modules.crud.config.author') ?> <<?= config('modules.crud.config.author_email') ?>>
 */
class <?= $crud->controllerClassName() ?> extends Controller
{
    /**
     * El directorio donde están las vistas.
     *
     * @var String
     */
    private $viewsDir = "<?= $crud->viewsDirName() ?>";
    
    /**
     * @var <?= config('modules.crud.config.parent-app-namespace') ?>\Services\<?= $crud->modelClassName() ?>Service
     */
    private $<?= $crud->modelVariableName() ?>Service;
    
    /**
     * Create a new controller instance.
     */
    public function __construct(<?= $crud->modelClassName() ?>Service $<?= $crud->modelVariableName() ?>Service)
    {
        // el usuario debe estar autenticado para acceder al controlador
        $this->middleware('auth');
        // el usuario debe tener permisos para acceder al controlador
        $this->middleware('<?= config("modules.crud.config.permissions-middleware") ?>', ['except' => ['store', 'update']]);
        $this-><?= $crud->modelVariableName() ?>Service = $<?= $crud->modelVariableName() ?>Service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Requests\<?= $crud->modelClassName()."Request" ?> $request
     *
     * @return Illuminate\Http\Response
     */
    public function index(<?= $crud->modelClassName()."Request" ?> $request)
    {
        $data = $this-><?= $crud->modelVariableName() ?>Service->getIndexTableData($request);
        $data['records'] = $this-><?= $crud->modelVariableName() ?>Service->indexSearch($request);

        return $this->view('index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this-><?= $crud->modelVariableName() ?>Service->getCreateFormData();
        return $this->view('create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Requests\<?= $crud->modelClassName()."Request" ?>  $request
     *
     * @return Illuminate\Http\Response
     */
    public function store(<?= $crud->modelClassName()."Request" ?> $request)
    {
        $this-><?= $crud->modelVariableName() ?>Service->store($request);
        return redirect()->route('<?= $crud->route().'.index' ?>');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $data = $this-><?= $crud->modelVariableName() ?>Service->getShowFormData($id);
        return $this->view('show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $data = $this-><?= $crud->modelVariableName() ?>Service->getEditFormData($id);
        return $this->view('edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Requests\<?= $crud->modelClassName()."Request" ?> $request
     *
     * @return Illuminate\Http\Response
     */
    public function update(int $id, <?= $crud->modelClassName()."Request" ?> $request)
    {
        $this-><?= $crud->modelVariableName() ?>Service->update($id, $request);
        
        if ($request->isXmlHttpRequest()) {
            return response('ok!!', 204);
        }

        return redirect()->route('<?= $crud->route().'.index' ?>');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Requests\<?= $crud->modelClassName()."Request" ?> $request
     *
     * @return Illuminate\Http\Response
     */
    public function destroy(int $id, <?= $crud->modelClassName()."Request" ?> $request)
    {
        $this-><?= $crud->modelVariableName() ?>Service->destroy($id, $request);
        return redirect()->route('<?= $crud->route().'.index' ?>');
    }

<?php if ($crud->hasDeletedAtColumn($fields)) { ?>
    /**
     * Restore the specified resource from storage.
     *
     * @param int $id
     * @param <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Requests\<?= $crud->modelClassName()."Request" ?> $request
     *
     * @return Illuminate\Http\Response
     */
    public function restore(int $id, <?= $crud->modelClassName()."Request" ?> $request)
    {
        $this-><?= $crud->modelVariableName() ?>Service->restore($id, $request);
        return redirect()->route('<?= $crud->route().'.index' ?>');
    }
<?php } ?>
    
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
        return view($this->viewsDir.'.'.$view, $data);
    }
}
