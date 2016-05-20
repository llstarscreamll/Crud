<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request [] */
?>
<?='<?php'?>

namespace Page\Functional\{{$gen->studlyCasePlural()}};

@if($request->has('use_faker') && !$request->has('use_base_class'))
use Faker\Factory as Faker;
@endif
@if($request->has('use_base_class'))
use Page\Functional\Base as BaseTests;
@else
use Carbon\Carbon;
@if($request->has('create_employees_data'))
use {{config('llstarscreamll.CrudGenerator.config.position-model-namespace')}}Position;
use {{config('llstarscreamll.CrudGenerator.config.sub-cost-center-model-namespace')}}SubCostCenter;
use {{config('llstarscreamll.CrudGenerator.config.cost-center-model-namespace')}}CostCenter;
@endif
use {{config('llstarscreamll.CrudGenerator.config.user-model-namespace')}}User;
@endif

class {{$test}} @if($request->has('use_base_class')) extends BaseTests @endif
{
    /**
     * La URL del index del módulo.
     * @var string
     */
    public static $moduleURL = '/{{$gen->route()}}';

	/**
     * Nombre del módulo.
     * @var array
     */
    static $moduleName = array();

     /**
     * La info de creación del módulo.
     * @var array
     */
    static ${{$gen->modelVariableName()}}Data = array();

    @if($request->has('use_faker'))
    /**
     * @var Faker\Factory
     */
	static $faker;
	@endif

    /**
     * Los campos del formulario de creación.
     * @var array
     */
    static $formFields = [
    	@foreach($fields as $field)
    		@if($field->in_form_field)
    			'{{$field->name}}',
    		@endif
    	@endforeach
    ];

    /**
     * Los campos del formulario de edición.
     * @var array
     */
    static $updateFormFields = [
        @foreach($fields as $field)
            @if($field->on_update_form_field)
                '{{$field->name}}',
            @endif
        @endforeach
    ];

    /**
     * Los campos a ocultar.
     * @var array
     */
    static $hiddenFields = [
        @foreach($fields as $field)
            @if($field->hidden)
                '{{$field->name}}',
            @endif
        @endforeach
    ];

    @if(!$request->has('use_base_class'))
    /**
     * The user admin data, this user is the actor
     * in all scenarios in admin role contexts.
     *
     * @var array
     */
    static $adminUser = [
        'name'          =>      'Travis',
        'lastname'      =>      'Orbin',
        'email'         =>      'travis.orbin@example.com',
        'password'      =>      '123456',
        'activated'     =>      1,
    ];

    /**
     * Para timestamps de creación de datos.
     * @var Carbon\Carbon
     */
    static $date;
    @endif

    /**
     * @var \FunctionalTester;
     */
    protected $functionalTester;

    /**
     * Instancia de la clase Base.
     * @param  \FunctionalTester $I
     * @return void
     */
    public function __construct(\FunctionalTester $I)
    {
        $this->functionalTester = $I;
        @if($request->has('use_faker'))
        self::$faker = Faker::create();
		@endif
        // crea los permisos de acceso al módulo
        \Artisan::call('db:seed', ['--class' => '{{$gen->modelClassName()}}PermissionsSeeder']);
        @if(!$request->has('use_base_class'))
        self::$date = Carbon::now();
        $this->createUserRoles();
        $this->createAdminUser();
        @endif

        @if($request->has('use_base_class'))
        // inicializamos los datos base de la aplicación como permisos,
        // roles, usuario admin, etc...
        parent::__construct($I);
        @endif

        // damos valores a las variables para creación de un registro para el módulo
        self::${{$gen->modelVariableName()}}Data = [
            @foreach($fields as $field)
            	'{{$field->name}}' => {!!$field->testData!!},
            @endforeach
        ];

        @if($request->has('create_employees_data'))
        // crea empleados de prueba, para crear empleados necesito centros
        // y subcentros de costo
        $this->createCostCenters();
        $this->createSubCostCenters();
        $this->createEmployees();
        @endif

        self::$moduleName = [
            'txt' => trans('{{$gen->getLangAccess()}}/views.module.name'),
            'selector' => '{{config('llstarscreamll.CrudGenerator.uimap.module-title-selector')}}'
        ];
    }

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }

    @if(!$request->has('use_base_class'))
    /**
     * Crea los roles de usuario del sistema
     * @return void
     */
    public function createUserRoles()
    {
        \Artisan::call('db:seed', ['--class' => 'RoleTableSeeder']);
    }

    /**
     * Crea el usuario administrador.
     * @return Model El modelo del usuario creado
     */
    public function createAdminUser()
    {
        $user = User::firstOrCreate(
            array_merge(
                self::$adminUser,
                ['password' => bcrypt(self::$adminUser['password'])]
            )
        );

        // añado rol admin al usuario
        $user->attachRole(2);

        return $user;
    }    
    @endif

    @if(!$request->has('use_base_class') && $request->has('create_employees_data'))
    /**
     * Crea los centros de costo.
     * @return void
     */
    public function createCostCenters()
    {
        $data = [];
        
        $data[] = [
            'name'          => 'Proyecto Beteitiva',
            'short_name'    => 'beteitiva',
            'description'   => 'La mina Beteitiva',
            'created_at'    =>  self::$date->toDateTimeString(),
            'updated_at'    =>  self::$date->toDateTimeString(),
            'deleted_at'    =>  null
        ];

        $data[] = [
            'name'          => 'Proyecto Sanoha',
            'short_name'    => 'sanoha',
            'description'   => 'La mina Sanoha',
            'created_at'    =>  self::$date->toDateTimeString(),
            'updated_at'    =>  self::$date->toDateTimeString(),
            'deleted_at'    =>  null
        ];
        
        $data[] = [
            'name'          => 'Proyecto Cazadero',
            'short_name'    => 'cazadero',
            'description'   => 'La mina Cazadero',
            'created_at'    =>  self::$date->toDateTimeString(),
            'updated_at'    =>  self::$date->toDateTimeString(),
            'deleted_at'    =>  null
        ];
        
        $data[] = [
            'name'          => 'Proyecto Pinos',
            'short_name'    => 'pinos',
            'description'   => 'La mina Pinos',
            'created_at'    =>  self::$date->toDateTimeString(),
            'updated_at'    =>  self::$date->toDateTimeString(),
            'deleted_at'    =>  null
        ];

        \DB::table('cost_centers')->insert($data);
    }

    /**
     * Crea los subcentros de costo según tantos centros de costo haya.
     * @return void
     */
    public function createSubCostCenters()
    {
        $data = [];
        $costCenters = CostCenter::all();

        // creamos dos subcentros de costo por cada centro que haya
        foreach ($costCenters as $costCenter) {
            $data[] = [
                'cost_center_id'    =>      $costCenter->id,
                'name'              =>      'Subcentro 1',
                'short_name'        =>      'S1',
                'description'       =>      'Descripción de Subcentro',
                'created_at'        =>      self::$date->toDateTimeString(),
                'updated_at'        =>      self::$date->toDateTimeString()
            ];
            
            $data[] = [
                'cost_center_id'    =>      $costCenter->id,
                'name'              =>      'Subcentro 2',
                'short_name'        =>      'S2',
                'description'       =>      'Descripción de Subcentro',
                'created_at'        =>      self::$date->toDateTimeString(),
                'updated_at'        =>      self::$date->toDateTimeString()
            ];
        }
        
        \DB::table('sub_cost_centers')->insert($data);
    }

    /**
     * Crea algunos empleados de prueba.
     * @return void
     */
    public static function createEmployees()
    {
        $data = [];
        $subCostCenters = SubCostCenter::all();
        $count = 1;
                
        Position::create([
            'name'  =>  'Minero'
        ]);
        
        foreach ($subCostCenters as $subCostCenter) {
            $data[] = [
                'sub_cost_center_id'    =>      $subCostCenter->id,
                'position_id'           =>      1,
                'internal_code'         =>      $count+1,
                'identification_number' =>      $count+2,
                'name'                  =>      'Empleado ' . $count,
                'lastname'              =>      $subCostCenter->short_name,
                'email'                 =>      'Empleado'.$count++.'@example.com',
                'city'                  =>      'Nobsa',
                'address'               =>      'carrera #11 - 36',
                'phone'                 =>      '3115318813',
                'created_at'            =>      self::$date->toDateTimeString(),
                'updated_at'            =>      self::$date->toDateTimeString(),
                'deleted_at'            =>      null
            ];
        }
        
        \DB::table('employees')->insert($data);
    }
    @endif

    /**
     * Crea un registro del modelo en la base de datos.
     * @return void
     */
    public static function have{{$gen->modelClassName()}}(\FunctionalTester $I)
    {
    	$I->haveRecord('{{$gen->table_name}}', self::${{$gen->modelVariableName()}}Data);
    }

    /**
     * Devuelve array con los datos para creación de un registro.
     * @return array
     */
    public static function getCreateData()
    {
        $data = array();

        foreach (self::${{$gen->modelVariableName()}}Data as $key => $value) {
            if (in_array($key, self::$formFields)) {
                $data[$key] = $value;
            }
        }

        return $data;
    }
}