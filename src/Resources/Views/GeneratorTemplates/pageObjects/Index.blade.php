<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


namespace Page\Functional\{{$gen->studlyCasePlural()}};

use FunctionalTester;
use {{config('modules.CrudGenerator.config.user-model-namespace')}};
@if($request->has('use_faker'))
use Faker\Factory as Faker;
@endif
@foreach($fields as $field)
@if($field->namespace !== "" && class_basename($field->namespace) !== 'User')
use {!! $field->namespace !!};
@endif
@endforeach

class {{$test}}
{
    /**
     * La URL del index del módulo.
     *
     * @var string
     */
    public static $moduleURL = '/{{$gen->route()}}';

    /**
     * Nombre del módulo.
     *
     * @var string
     */
    static $moduleName = '{!!$request->get('plural_entity_name')!!}';
    static $titleElem = '{{config('modules.CrudGenerator.uimap.module-title-selector')}}';
    static $titleSmallElem = '{{config('modules.CrudGenerator.uimap.module-title-small-selector')}}';

    /**
     * El selector de la tabla donde se listan los registros.
     *
     * @var string
     */
    static $table = '{{config('modules.CrudGenerator.uimap.index-table-selector')}}';

    /**
     * 
     * Mensaje cuando no se encuentran datos.
     *
     * @var array
     */
    static $noDataFountMsg = 'No se encontraron registros...';
    static $noDataFountMsgElem = '{{config('modules.CrudGenerator.uimap.alert-warning-selector')}}';

    /**
     * La info de creación del registro.
     *
     * @var array
     */
    static ${{$gen->modelVariableName()}}Data = array();

    /**
     * Los campos del formulario de creación.
     *
     * @var array
     */
    static $createFormFields = [
@foreach($fields as $field)
@if($field->on_create_form)
        '{{$field->name}}',
@endif
@endforeach
    ];

     /**
     * Los campos del formulario de edición.
     *
     * @var array
     */
    static $editFormFields = [
@foreach($fields as $field)
@if($field->on_update_form)
        '{{$field->name}}',
@endif
@endforeach
    ];

    /**
     * Los campos que requieren confirmación.
     *
     * @var array
     */
    static $fieldsThatRequieresConfirmation = [
@foreach($fields as $field)
@if(strpos($field->validation_rules, 'confirmed'))
        '{{$field->name}}'
@endif
@endforeach
    ];

    /**
     * Los campos a ocultar.
     *
     * @var array
     */
    static $hiddenFields = [
@foreach($fields as $field)
@if($field->hidden)
        '{{$field->name}}',
@endif
@endforeach
    ];

    /**
     * Los datos del usuario que actúa en los tests.
     *
     * @var array
     */
    static $adminUser = [
        'name'          =>      'Travis Orbin',
        'email'         =>      'travis.orbin@example.com',
        'password'      =>      '123456',
    ];

    /**
     * @var FunctionalTester;
     */
    protected $functionalTester;

    public function __construct(FunctionalTester $I)
    {
        $this->functionalTester = $I;

        // creamos permisos de acceso
        \Artisan::call('db:seed', ['--class' => '{{$gen->modelClassName()}}PermissionsSeeder']);
        \Artisan::call('db:seed', ['--class' => '{{config('modules.CrudGenerator.config.test-roles-seeder-class')}}']);
        // creamos usuario admin de prueba
        \Artisan::call('db:seed', ['--class' => '{{config('modules.CrudGenerator.config.test-users-seeder-class')}}']);
@foreach($fields as $field)
@if($field->namespace)
        \Artisan::call('db:seed', ['--class' => '{{$gen->getTableSeederClassName($field)}}']);
@endif
@endforeach

        // damos valores a los atributos para crear un registro
        static::${{$gen->modelVariableName()}}Data = [
@foreach($fields as $field)
            '{{$field->name}}' => {!! $field->namespace == '' ? $field->testData : class_basename($field->namespace)."::first(['id'])->id" !!},
@endforeach
        ];
@if($request->has('create_employees_data'))
        // crea empleados de prueba, para crear empleados necesito centros y
        // subcentros de costo
        \Artisan::call('db:seed', ['--class' => 'SubCostCentersTableSeeder']);
        \Artisan::call('db:seed', ['--class' => 'CostCentersTableSeeder']);
        \Artisan::call('db:seed', ['--class' => 'EmployeesTableSeeder']);

@endif
    }

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     *
     * @param  string  $param
     *
     * @return string
     */
    public static function route($param)
    {
        return static::$moduleURL.$param;
    }

    /**
     * Crea un registro del modelo en la base de datos.
     *
     * @param  FunctionalTester $I
     *
     * @return int El id del modelo generado
     */
    public static function have{{$gen->modelClassName()}}(FunctionalTester $I)
    {
        return $I->haveRecord('{{$gen->table_name}}', static::${{$gen->modelVariableName()}}Data);
    }

    /**
     * Devuelve array con los datos para creación de un registro.
     *
     * @return array
     */
    public static function getCreateData()
    {
        $data = array();

        foreach (static::${{$gen->modelVariableName()}}Data as $key => $value) {
            if (in_array($key, static::$createFormFields)) {
                $data[$key] = $value;
            }
            if (in_array($key, static::$fieldsThatRequieresConfirmation)){
                $data[$key.'_confirmation'] = $value;
            }
        }

        return $data;
    }

    /**
     * Obtiene los datos que deben estar en la tabla del index, es decir que
     * tenemos que extraer los datos legibles para usuario, como los datos
     * necesarios de las relaciones de la entidad, traducción de campos tipo
     * enum, etc.
     *
     * @return array
     */
    public static function getIndexTableData()
    {
        $data = static::${{$gen->modelVariableName()}}Data;

        // los datos de las llaves foráneas
@foreach($fields as $field)
@if($field->namespace)
        $data['{{ $field->name }}'] = {{ class_basename($field->namespace) }}::find($data['{{ $field->name }}'])->name;
@endif
@endforeach
        
        // los atributos ocultos no deben mostrarse en la tabla del index
        foreach (static::$hiddenFields as $key => $attr) {
            if (isset($data[$attr])) {
                unset($data[$attr]);
            }
        }

        return $data;
    }

    /**
     * Resta del parámetro $data los elementos del array static::$hiddenFields.
     *
     * @return array
     */
    public static function unsetHiddenFields(array $data)
    {
        $data = !empty($data) ? $data : static::${{$gen->modelVariableName()}}Data;

        // quitamos del array los elementos de static::$hiddenFields
        foreach (static::$hiddenFields as $key => $value) {
            unset($data[$value]);
        }

        return $data;
    }

    /**
     * Quita del array los indeces que tengan como sufijo "_confirmation" en el
     * nombre.
     *
     * @param  array  $data
     *
     * @return array
     */
    public static function unsetConfirmationFields(array $data = [])
    {
        $data = !empty($data) ? $data : static::${{$gen->modelVariableName()}}Data;
        $confirmedFields = static::$fieldsThatRequieresConfirmation;
        $requiredField = '';

        // los campos ocultos no deben ser mostrados en la vista de sólo lectura
        foreach ($confirmedFields as $key => $value) {
            $requiredField = $value.'_confirmation';
            if (in_array($requiredField, $data)) {
                unset($data[$requiredField]);
            }
        }

        return $data;
    }
}
