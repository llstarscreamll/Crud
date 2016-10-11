<?php
namespace Page\Functional\Users;

use Carbon\Carbon;
use llstarscreamll\CoreModule\app\Models\User;

class Base {
	/**
     * Nombre del módulo.
     * @var  array
     */
    static $moduleName = array();

     /**
     * La info de creación del módulo.
     * @var  array
     */
    static $userData = array();

    
    /**
     * @var  \FunctionalTester;
     */
    protected $functionalTester;

    /**
     * Los campos del formulario de creación.
     * @var  array
     */
    static $formFields = [
    	    		    	    		    			'name',
    		    	    		    			'lastname',
    		    	    		    			'email',
    		    	    		    			'password',
    		    	    		    			'activated',
    		    	    		    	    		    	    		    	    		    	    ];

    /**
     * Los campos del formulario de edición.
     * @var  array
     */
    static $updateFormFields = [
                                                        'name',
                                                'lastname',
                                                'email',
                                                                    'activated',
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
     * Instancia de la clase Base.
     * @param    \FunctionalTester $I
     * @return  void
     */
    public function __construct(\FunctionalTester $I)
    {
        $this->functionalTester = $I;
                // crea los permisos de acceso al módulo
        \Artisan::call('db:seed', ['--class' => 'UserPermissionsSeeder']);
                self::$date = Carbon::now();
        $this->createUserRoles();
        $this->createAdminUser();
        
        
        // damos valores a las variables para creación de un registro para el módulo
        self::$userData = [
                        	'id' => null,
                        	'name' => 'John',
                        	'lastname' => 'Weak',
                        	'email' => 'johan@weak.com',
                        	'password' => bcrypt('123456'),
                        	'activated' => 1,
                        	'remember_token' => null,
                        	'created_at' => date('Y-m-d H:i:s'),
                        	'updated_at' => date('Y-m-d H:i:s'),
                        	'deleted_at' => null,
                    ];

        
        self::$moduleName = [
            'txt' => trans('user/views.module.name'),
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

        // añado rol admin al usuario
        $user->attachRole(2);

        return $user;
    }    
    
    
    /**
     * Crea un registro del modelo en la base de datos.
     * @return  void
     */
    public static function haveUser(\FunctionalTester $I)
    {
    	$I->haveRecord('users', self::$userData);
    }

    /**
     * Devuelve array con los datos para creación de un registro.
     * @return  array
     */
    public static function getCreateData()
    {
        $data = array();

        foreach (self::$userData as $key => $value) {
            if (in_array($key, self::$formFields)) {
                $data[$key] = $value;
            }
        }

        $data['password'] = '123456';
        $data['password_confirmation'] = '123456';

        return $data;
    }
}