<?php
namespace Page\Functional\Books;

use Carbon\Carbon;
use llstarscreamll\CoreModule\app\Models\User;

class Base {
    /**
     * La URL del index del módulo.
     * @var  string
     */
    public static $moduleURL = '/books';

    /**
     * Nombre del módulo.
     * @var  array
     */
    static $moduleName = array();

     /**
     * La info de creación del módulo.
     * @var  array
     */
    static $bookData = array();


    /**
     * Los campos del formulario de creación.
     * @var  array
     */
    static $formFields = [
        'reason_id',
        'name',
        'author',
        'genre',
        'stars',
        'published_year',
        'enabled',
        'status',
        'unlocking_word',
        'synopsis',
    ];

    /**
     * Los campos del formulario de edición.
     * @var  array
     */
    static $updateFormFields = [
        'reason_id',
        'name',
        'author',
        'genre',
        'stars',
        'published_year',
        'enabled',
        'status',
        'unlocking_word',
        'synopsis',
    ];

    /**
     * Los campos que requieren confirmación.
     * @var  array
     */
    static $fieldsThatRequieresConfirmation = [
        'unlocking_word'
    ];

    /**
     * Los campos a ocultar.
     * @var  array
     */
    static $hiddenFields = [
        'unlocking_word',
        'approved_password',
    ];

    /**
     * The user admin data, this user is the actor
     * in all scenarios in admin role contexts.
     *
     * @var  array
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
     * @var  Carbon\Carbon
     */
    static $date;

    /**
     * @var  \FunctionalTester;
     */
    protected $functionalTester;

    /**
     * Instancia de la clase Base.
     * @param    \FunctionalTester $I
     * @return  void
     */
    public function __construct(\FunctionalTester $I)
    {
        $this->functionalTester = $I;

        self::$date = Carbon::now();
        $this->createUserRoles();
        $this->createAdminUser();

        // crea los permisos de acceso al módulo
        \Artisan::call('db:seed', ['--class' => 'BookPermissionsSeeder']);
        \Artisan::call('db:seed', ['--class' => 'ReasonsTableSeeder']);
        \Artisan::call('db:seed', ['--class' => 'UsersTableSeeder']);


        // damos valores a las variables para creación de un registro para el módulo
        self::$bookData = [
            'id' => 1,
            'reason_id' => 1,
            'name' => "Cien Años de Soledad",
            'author' => "Gabo Marquez",
            'genre' => "Ficción",
            'stars' => "4",
            'published_year' => date("Y-m-d"),
            'enabled' => false,
            'status' => "waiting_confirmation",
            'unlocking_word' => "asdfg",
            'synopsis' => "Esta es una prueba de sinopsis...",
            'approved_at' => date("Y-m-d H:i:s"),
            'approved_by' => 1,
            'approved_password' => "123456",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'deleted_at' => null,
        ];


        self::$moduleName = [
            'txt' => trans('book/views.module.name'),
            'selector' => '.content-header h1'
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

    /**
     * Crea los roles de usuario del sistema
     * @return  void
     */
    public function createUserRoles()
    {
        \Artisan::call('db:seed', ['--class' => 'RoleTableSeeder']);
    }

    /**
     * Crea el usuario administrador.
     * @return  Model El modelo del usuario creado
     */
    public function createAdminUser()
    {
        $user = User::firstOrCreate(
            array_merge(
                self::$adminUser,
                ['password' => bcrypt(self::$adminUser['password'])]
            )
        );

        $admin_role = \llstarscreamll\CoreModule\app\Models\Role::where('name', 'admin')->first()->id;

        // añado rol admin al usuario
        $user->attachRole($admin_role);

        return $user;
    }    


    /**
     * Crea un registro del modelo en la base de datos.
     * @return  void
     */
    public static function haveBook(\FunctionalTester $I)
    {
        $I->haveRecord('books', self::$bookData);
    }

    /**
     * Devuelve array con los datos para creación de un registro.
     * @return  array
     */
    public static function getCreateData()
    {
        $data = array();

        foreach (self::$bookData as $key => $value) {
            if (in_array($key, self::$formFields)) {
                $data[$key] = $value;
            }
            if (in_array($key, self::$fieldsThatRequieresConfirmation)){
                $data[$key.'_confirmation'] = $value;
            }
        }

        return $data;
    }
}