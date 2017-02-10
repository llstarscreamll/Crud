<?php

namespace Crud\Page\Functional;

use Crud\FunctionalTester;
use llstarscreamll\Core\Models\User;
use llstarscreamll\Core\Models\Role;

class Generate
{
    /**
     * Los datos del formulario.
     *
     * @var array
     */
    public static $formData = [
        'app_type' => 'laravel_app',
        'UI_theme' => 'Inspinia',
        'is_part_of_package' => 'Books',
        'table_name' => 'books',
        'use_faker' => false,
        'use_base_class' => false,
        'create_employees_data' => false,
        'create_permissions' => true,
        'plural_entity_name' => 'Libros',
        'single_entity_name' => 'Libro',
        'id_for_user' => 'name',
        'checkbox_component_on_index_table' => 'iCheck',
        'use_modal_confirmation_on_delete' => true,
        'use_DateTimePicker_on_form_fields' => true,
        'use_x_editable' => false,
        'include_assets' => false,

        // para la columna id
        'field[0][name]' => 'id',
        'field[0][type]' => 'int',
        'field[0][required]' => true,
        'field[0][defValue]' => '',
        'field[0][key]' => 'PRI',
        'field[0][maxLength]' => '10',
        'field[0][namespace]' => '',
        'field[0][relation]' => '',
        'field[0][fillable]' => false,
        'field[0][hidden]' => false,
        'field[0][on_index_table]' => true,
        'field[0][on_create_form]' => false,
        'field[0][on_update_form]' => false,
        'field[0][label]' => 'El id',
        'field[0][testData]' => '1',
        'field[0][testDataUpdate]' => '1',
        'field[0][validation_rules]' => 'numeric',

        // para la columna reason_id
        'field[1][name]' => 'reason_id',
        'field[1][type]' => 'int',
        'field[1][required]' => true,
        'field[1][defValue]' => 'belongsTo',
        'field[1][key]' => 'MUL',
        'field[1][maxLength]' => '10',
        'field[1][namespace]' => 'App\Models\Reason',
        'field[1][relation]' => 'belongsTo',
        'field[1][fillable]' => true,
        'field[1][hidden]' => false,
        'field[1][on_index_table]' => true,
        'field[1][on_create_form]' => true,
        'field[1][on_update_form]' => true,
        'field[1][label]' => 'El motivo',
        'field[1][testData]' => 1,
        'field[1][testDataUpdate]' => 2,
        'field[1][validation_rules]' => 'required|numeric|exists:reasons,id',

        // para la columna name
        'field[2][name]' => 'name',
        'field[2][type]' => 'varchar',
        'field[2][required]' => true,
        'field[2][defValue]' => '',
        'field[2][key]' => '',
        'field[2][maxLength]' => '255',
        'field[2][namespace]' => '',
        'field[2][relation]' => '',
        'field[2][fillable]' => true,
        'field[2][hidden]' => false,
        'field[2][on_index_table]' => true,
        'field[2][on_create_form]' => true,
        'field[2][on_update_form]' => true,
        'field[2][label]' => 'El nombre',
        'field[2][testData]' => '"Cien Años de Soledad"',
        'field[2][testDataUpdate]' => '"El Coronel No Tiene Quien Le Escriba"',
        'field[2][validation_rules]' => 'required|string',

        // para la columna author
        'field[3][name]' => 'author',
        'field[3][type]' => 'varchar',
        'field[3][required]' => true,
        'field[3][defValue]' => '',
        'field[3][key]' => '',
        'field[3][maxLength]' => '255',
        'field[3][namespace]' => '',
        'field[3][relation]' => '',
        'field[3][fillable]' => true,
        'field[3][hidden]' => false,
        'field[3][on_index_table]' => true,
        'field[3][on_create_form]' => true,
        'field[3][on_update_form]' => true,
        'field[3][label]' => 'El autor',
        'field[3][testData]' => '"Gabo Marquez"',
        'field[3][testDataUpdate]' => '"Gabriel García Márquez"',
        'field[3][validation_rules]' => 'required|string',

        // para la columna genre
        'field[4][name]' => 'genre',
        'field[4][type]' => 'varchar',
        'field[4][required]' => true,
        'field[4][defValue]' => '',
        'field[4][key]' => '',
        'field[4][maxLength]' => '255',
        'field[4][namespace]' => '',
        'field[4][relation]' => '',
        'field[4][fillable]' => true,
        'field[4][hidden]' => false,
        'field[4][on_index_table]' => false,
        'field[4][on_create_form]' => true,
        'field[4][on_update_form]' => true,
        'field[4][label]' => 'El género',
        'field[4][testData]' => '"Ficción"',
        'field[4][testDataUpdate]' => '"Thriller"',
        'field[4][validation_rules]' => 'required|string',

        // para la columna stars
        'field[5][name]' => 'stars',
        'field[5][type]' => 'int',
        'field[5][required]' => true,
        'field[5][defValue]' => '1',
        'field[5][key]' => '',
        'field[5][maxLength]' => '11',
        'field[5][namespace]' => '',
        'field[5][relation]' => '',
        'field[5][fillable]' => true,
        'field[5][hidden]' => false,
        'field[5][on_index_table]' => false,
        'field[5][on_create_form]' => true,
        'field[5][on_update_form]' => true,
        'field[5][label]' => 'Las estrellas',
        'field[5][testData]' => '"4"',
        'field[5][testDataUpdate]' => '"5"',
        'field[5][validation_rules]' => 'required|numeric',

        // para la columna published_year
        'field[6][name]' => 'published_year',
        'field[6][type]' => 'date',
        'field[6][required]' => true,
        'field[6][defValue]' => '',
        'field[6][key]' => '',
        'field[6][maxLength]' => '0',
        'field[6][namespace]' => '',
        'field[6][relation]' => '',
        'field[6][fillable]' => true,
        'field[6][hidden]' => false,
        'field[6][on_index_table]' => false,
        'field[6][on_create_form]' => true,
        'field[6][on_update_form]' => true,
        'field[6][label]' => 'La fecha de publicación',
        'field[6][testData]' => 'date("Y-m-d")',
        'field[6][testDataUpdate]' => '"2016-05-05"',
        'field[6][validation_rules]' => 'required|date_format:Y-m-d',

        // para la columna enabled
        'field[7][name]' => 'enabled',
        'field[7][type]' => 'tinyint',
        'field[7][required]' => true,
        'field[7][defValue]' => '1',
        'field[7][key]' => '',
        'field[7][maxLength]' => '1',
        'field[7][namespace]' => '',
        'field[7][relation]' => '',
        'field[7][fillable]' => true,
        'field[7][hidden]' => false,
        'field[7][on_index_table]' => false,
        'field[7][on_create_form]' => true,
        'field[7][on_update_form]' => true,
        'field[7][label]' => 'Activado?',
        'field[7][testData]' => 'false',
        'field[7][testDataUpdate]' => 'true',
        'field[7][validation_rules]' => 'boolean',

        // para la columna status
        'field[8][name]' => 'status',
        'field[8][type]' => 'enum',
        'field[8][required]' => true,
        'field[8][defValue]' => '',
        'field[8][key]' => '',
        'field[8][maxLength]' => '0',
        'field[8][namespace]' => '',
        'field[8][relation]' => '',
        'field[8][fillable]' => true,
        'field[8][hidden]' => false,
        'field[8][on_index_table]' => false,
        'field[8][on_create_form]' => true,
        'field[8][on_update_form]' => true,
        'field[8][label]' => 'El estado',
        'field[8][testData]' => '"waiting_confirmation"',
        'field[8][testDataUpdate]' => '"approved"',
        'field[8][validation_rules]' => "required|alpha_dash",

        // para la columna unlocking_word
        'field[9][name]' => 'unlocking_word',
        'field[9][type]' => 'varchar',
        'field[9][required]' => true,
        'field[9][defValue]' => '',
        'field[9][key]' => '',
        'field[9][maxLength]' => '255',
        'field[9][namespace]' => '',
        'field[9][relation]' => '',
        'field[9][fillable]' => true,
        'field[9][hidden]' => true,
        'field[9][on_index_table]' => true,
        'field[9][on_create_form]' => true,
        'field[9][on_update_form]' => true,
        'field[9][label]' => 'La palabra de desbloqueo',
        'field[9][testData]' => '"asdfg"',
        'field[9][testDataUpdate]' => '"asdfghjklñ"',
        'field[9][validation_rules]' => 'required|confirmed',

        // para la columna synopsis
        'field[10][name]' => 'synopsis',
        'field[10][type]' => 'text',
        'field[10][required]' => false,
        'field[10][defValue]' => '',
        'field[10][key]' => '',
        'field[10][maxLength]' => '0',
        'field[10][namespace]' => '',
        'field[10][relation]' => '',
        'field[10][fillable]' => true,
        'field[10][hidden]' => false,
        'field[10][on_index_table]' => false,
        'field[10][on_create_form]' => true,
        'field[10][on_update_form]' => true,
        'field[10][label]' => 'La sinopsis',
        'field[10][testData]' => '"Esta es una prueba de sinopsis..."',
        'field[10][testDataUpdate]' => '"Esta es una prueba de actualización de sinopsis..."',
        'field[10][validation_rules]' => 'string',

        // para la columna approved_at
        'field[11][name]' => 'approved_at',
        'field[11][type]' => 'datetime',
        'field[11][required]' => false,
        'field[11][defValue]' => '',
        'field[11][key]' => '',
        'field[11][maxLength]' => '0',
        'field[11][namespace]' => '',
        'field[11][relation]' => '',
        'field[11][fillable]' => true,
        'field[11][hidden]' => false,
        'field[11][on_index_table]' => true,
        'field[11][on_create_form]' => false,
        'field[11][on_update_form]' => false,
        'field[11][label]' => 'La fecha de aprobación',
        'field[11][testData]' => 'date("Y-m-d H:i:s")',
        'field[11][testDataUpdate]' => '"2016-02-02 08:00:00"',
        'field[11][validation_rules]' => '',

        // para la columna approved_by
        'field[12][name]' => 'approved_by',
        'field[12][type]' => 'int',
        'field[12][required]' => false,
        'field[12][defValue]' => '',
        'field[12][key]' => 'MUL',
        'field[12][maxLength]' => '10',
        'field[12][namespace]' => 'llstarscreamll\Core\Models\User',
        'field[12][relation]' => 'belongsTo',
        'field[12][fillable]' => true,
        'field[12][hidden]' => false,
        'field[12][on_index_table]' => false,
        'field[12][on_create_form]' => false,
        'field[12][on_update_form]' => false,
        'field[12][label]' => 'El usuario que aprobó',
        'field[12][testData]' => 1,
        'field[12][testDataUpdate]' => 2,
        'field[12][validation_rules]' => '',

        // para la columna approved_password
        'field[13][name]' => 'approved_password',
        'field[13][type]' => 'varchar',
        'field[13][required]' => false,
        'field[13][defValue]' => '',
        'field[13][key]' => '',
        'field[13][maxLength]' => '255',
        'field[13][namespace]' => '',
        'field[13][relation]' => '',
        'field[13][fillable]' => true,
        'field[13][hidden]' => true,
        'field[13][on_index_table]' => true,
        'field[13][on_create_form]' => false,
        'field[13][on_update_form]' => false,
        'field[13][label]' => 'La contraseña de aprobación',
        'field[13][testData]' => '"123456"',
        'field[13][testDataUpdate]' => '"123456789"',
        'field[13][validation_rules]' => '',

        // para la columna created_at
        'field[14][name]' => 'created_at',
        'field[14][type]' => 'timestamp',
        'field[14][required]' => false,
        'field[14][defValue]' => '0000-00-00 00:00:00',
        'field[14][key]' => '',
        'field[14][maxLength]' => '0',
        'field[14][namespace]' => '',
        'field[14][relation]' => '',
        'field[14][fillable]' => false,
        'field[14][hidden]' => false,
        'field[14][on_index_table]' => true,
        'field[14][on_create_form]' => false,
        'field[14][on_update_form]' => false,
        'field[14][label]' => 'La fecha de creación',
        'field[14][testData]' => 'date("Y-m-d H:i:s")',
        'field[14][testDataUpdate]' => '',
        'field[14][validation_rules]' => '',

        // para la columna updated_at
        'field[15][name]' => 'updated_at',
        'field[15][type]' => 'timestamp',
        'field[15][required]' => false,
        'field[15][defValue]' => '0000-00-00 00:00:00',
        'field[15][key]' => '',
        'field[15][maxLength]' => '0',
        'field[15][namespace]' => '',
        'field[15][relation]' => '',
        'field[15][fillable]' => false,
        'field[15][hidden]' => false,
        'field[15][on_index_table]' => false,
        'field[15][on_create_form]' => false,
        'field[15][on_update_form]' => false,
        'field[15][label]' => 'La fecha de actualización',
        'field[15][testData]' => 'date("Y-m-d H:i:s")',
        'field[15][testDataUpdate]' => '',
        'field[15][validation_rules]' => '',

        // para la columna deleted_at
        'field[16][name]' => 'deleted_at',
        'field[16][type]' => 'timestamp',
        'field[16][required]' => false,
        'field[16][defValue]' => '0000-00-00 00:00:00',
        'field[16][key]' => '',
        'field[16][maxLength]' => '0',
        'field[16][namespace]' => '',
        'field[16][relation]' => '',
        'field[16][fillable]' => false,
        'field[16][hidden]' => false,
        'field[16][on_index_table]' => false,
        'field[16][on_create_form]' => false,
        'field[16][on_update_form]' => false,
        'field[16][label]' => 'La fecha de eliminiación',
        'field[16][testData]' => '',
        'field[16][testDataUpdate]' => '',
        'field[16][validation_rules]' => '',
    ];

    /**
     * The module URL.
     *
     * @var string
     */
    public static $URL = '/crud/showOptions';

    /**
     * The user admin data, this user is the actor
     * in all scenarios in admin role contexts.
     *
     * @var array
     */
    public static $adminUser = [
        'name' => 'Travis Orbin',
        'email' => 'travis.orbin@example.com',
        'password' => '123456',
    ];

    /**
     * El nombre de la tabla a la que crearemos la CRUD app.
     *
     * @var string
     */
    public static $tableName = 'books';

    /**
     * El título de la página.
     *
     * @var string
     */
    public static $title = 'Crud';

    /**
     * El elemento que contiene el título.
     *
     * @var string
     */
    public static $titleElem = '.panel-heading';

    /**
     * @var FunctionalTester;
     */
    protected $functionalTester;

    public function __construct(FunctionalTester $I)
    {
        $this->functionalTester = $I;

        $this->createUserRoles();
        $this->createAdminUser();
    }

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');.
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }

    /**
     * Crea los roles de usuario del sistema.
     */
    public function createUserRoles()
    {
        //\Artisan::call('db:seed', ['--class' => 'RoleTableSeeder']);
    }

    /**
     * Crea el usuario administrador.
     *
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

        /*$role = Role::where('name', 'admin')->first();

        // añado rol admin al usuario
        $user->attachRole($role->id);*/

        return $user;
    }
}
