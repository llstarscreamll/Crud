<?php

namespace Crud\Page\Functional;

use Crud\FunctionalTester;
use App\Containers\User\Models\User;

class Generate
{
    /**
     * Los datos del formulario.
     *
     * @var array
     */
    public static $formData = array (
          'table_name' => 'books',
          'generate_porto_container' => '1',
          'generate_angular_module' => '1',
          'create_permissions' => '1',
          'checkbox_component_on_index_table' => 'iCheck',
          'use_DateTimePicker_on_form_fields' => '1',
          'use_modal_confirmation_on_delete' => '1',
          'copy_porto_container_to' => NULL,
          'angular_module_location' => NULL,
          'plural_entity_name' => 'Libros',
          'single_entity_name' => 'Libro',
          'is_part_of_package' => 'Library',
          'id_for_user' => 'name',
          'language_key' => 'es',
          'field' => 
          array (
            'id' => 
            array (
              'name' => 'id',
              'type' => 'int',
              'required' => '1',
              'defValue' => NULL,
              'key' => 'PRI',
              'maxLength' => '10',
              'namespace' => NULL,
              'relation' => NULL,
              'label' => 'Id',
              'validation_rules' => 'numeric',
            ),
            'reason_id' => 
            array (
              'name' => 'reason_id',
              'type' => 'int',
              'required' => '1',
              'defValue' => NULL,
              'key' => 'MUL',
              'maxLength' => '10',
              'namespace' => 'App\\Containers\\Reason\\Models\\Reason',
              'relation' => 'belongsTo',
              'fillable' => '1',
              'on_create_form' => '1',
              'on_update_form' => '1',
              'label' => 'Motivo',
              'validation_rules' => 'numeric|exists:reasons,id',
            ),
            'name' => 
            array (
              'name' => 'name',
              'type' => 'varchar',
              'required' => '1',
              'defValue' => NULL,
              'key' => NULL,
              'maxLength' => '191',
              'namespace' => NULL,
              'relation' => NULL,
              'fillable' => '1',
              'on_index_table' => '1',
              'on_create_form' => '1',
              'on_update_form' => '1',
              'label' => 'Nombre',
              'validation_rules' => 'required|string',
            ),
            'author' => 
            array (
              'name' => 'author',
              'type' => 'varchar',
              'required' => '1',
              'defValue' => NULL,
              'key' => NULL,
              'maxLength' => '191',
              'namespace' => NULL,
              'relation' => NULL,
              'fillable' => '1',
              'on_index_table' => '1',
              'on_create_form' => '1',
              'on_update_form' => '1',
              'label' => 'Autor',
              'validation_rules' => 'required|string',
            ),
            'genre' => 
            array (
              'name' => 'genre',
              'type' => 'varchar',
              'required' => '1',
              'defValue' => NULL,
              'key' => NULL,
              'maxLength' => '191',
              'namespace' => NULL,
              'relation' => NULL,
              'fillable' => '1',
              'on_index_table' => '1',
              'on_create_form' => '1',
              'on_update_form' => '1',
              'label' => 'Genero',
              'validation_rules' => 'required|string',
            ),
            'stars' => 
            array (
              'name' => 'stars',
              'type' => 'int',
              'required' => '1',
              'defValue' => NULL,
              'key' => NULL,
              'maxLength' => '11',
              'namespace' => NULL,
              'relation' => NULL,
              'fillable' => '1',
              'on_index_table' => '1',
              'on_create_form' => '1',
              'on_update_form' => '1',
              'label' => 'Estrellas',
              'validation_rules' => 'numeric|min:1|max:5',
            ),
            'published_year' => 
            array (
              'name' => 'published_year',
              'type' => 'date',
              'required' => '1',
              'defValue' => NULL,
              'key' => NULL,
              'maxLength' => '0',
              'namespace' => NULL,
              'relation' => NULL,
              'fillable' => '1',
              'on_create_form' => '1',
              'on_update_form' => '1',
              'label' => 'Publicado en',
              'validation_rules' => 'required|date:Y',
            ),
            'enabled' => 
            array (
              'name' => 'enabled',
              'type' => 'tinyint',
              'defValue' => '1',
              'key' => NULL,
              'maxLength' => '1',
              'namespace' => NULL,
              'relation' => NULL,
              'fillable' => '1',
              'on_create_form' => '1',
              'on_update_form' => '1',
              'label' => 'Habilitado?',
              'validation_rules' => 'boolean',
            ),
            'status' => 
            array (
              'name' => 'status',
              'type' => 'enum',
              'required' => '1',
              'defValue' => NULL,
              'key' => NULL,
              'maxLength' => '0',
              'namespace' => NULL,
              'relation' => NULL,
              'fillable' => '1',
              'on_create_form' => '1',
              'on_update_form' => '1',
              'label' => 'Estado',
              'validation_rules' => 'required|string',
            ),
            'unlocking_word' => 
            array (
              'name' => 'unlocking_word',
              'type' => 'varchar',
              'required' => '1',
              'defValue' => NULL,
              'key' => NULL,
              'maxLength' => '191',
              'namespace' => NULL,
              'relation' => NULL,
              'fillable' => '1',
              'hidden' => '1',
              'on_create_form' => '1',
              'on_update_form' => '1',
              'label' => 'Palabra de desbloqueo',
              'validation_rules' => 'required|string|confirmed',
            ),
            'synopsis' => 
            array (
              'name' => 'synopsis',
              'type' => 'text',
              'defValue' => NULL,
              'key' => NULL,
              'maxLength' => '0',
              'namespace' => NULL,
              'relation' => NULL,
              'fillable' => '1',
              'on_create_form' => '1',
              'on_update_form' => '1',
              'label' => 'Sinopsis',
              'validation_rules' => 'string',
            ),
            'approved_at' => 
            array (
              'name' => 'approved_at',
              'type' => 'datetime',
              'defValue' => NULL,
              'key' => NULL,
              'maxLength' => '0',
              'namespace' => NULL,
              'relation' => NULL,
              'fillable' => '1',
              'on_create_form' => '1',
              'on_update_form' => '1',
              'label' => 'Aprobado el',
              'validation_rules' => 'date:Y-m-d H:i:s',
            ),
            'approved_by' => 
            array (
              'name' => 'approved_by',
              'type' => 'int',
              'defValue' => NULL,
              'key' => 'MUL',
              'maxLength' => '10',
              'namespace' => 'App\\Containers\\User\\Models\\User',
              'relation' => NULL,
              'label' => 'Aprobado por',
              'validation_rules' => 'exists:users,id',
            ),
            'approved_password' => 
            array (
              'name' => 'approved_password',
              'type' => 'varchar',
              'defValue' => NULL,
              'key' => NULL,
              'maxLength' => '191',
              'namespace' => NULL,
              'relation' => NULL,
              'fillable' => '1',
              'hidden' => '1',
              'on_create_form' => '1',
              'on_update_form' => '1',
              'label' => 'Contraseña de aprobación',
              'validation_rules' => 'string|confirmed',
            ),
            'created_at' => 
            array (
              'name' => 'created_at',
              'type' => 'timestamp',
              'defValue' => NULL,
              'key' => NULL,
              'maxLength' => '0',
              'namespace' => NULL,
              'relation' => NULL,
              'label' => 'Creado el',
              'validation_rules' => 'date:Y-m-d H:i:s',
            ),
            'updated_at' => 
            array (
              'name' => 'updated_at',
              'type' => 'timestamp',
              'defValue' => NULL,
              'key' => NULL,
              'maxLength' => '0',
              'namespace' => NULL,
              'relation' => NULL,
              'label' => 'Actualizado el',
              'validation_rules' => 'date:Y-m-d H:i:s',
            ),
            'deleted_at' => 
            array (
              'name' => 'deleted_at',
              'type' => 'timestamp',
              'defValue' => NULL,
              'key' => NULL,
              'maxLength' => '0',
              'namespace' => NULL,
              'relation' => NULL,
              'label' => 'Eliminado el',
              'validation_rules' => 'date:Y-m-d H:i:s',
            ),
          ),
        );

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
        'name' => 'Admin',
        'email' => 'admin@admin.com',
        'password' => 'admin',
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

        return $user;
    }
}
