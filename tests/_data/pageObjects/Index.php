<?php

/**
 * Este archivo es parte de Books.
 * (c) Johan Alvarez <llstarscreamll@hotmail.com>
 * Licensed under The MIT License (MIT).
 *
 * @package    Books
 * @version    0.1
 * @author     Johan Alvarez
 * @license    The MIT License (MIT)
 * @copyright  (c) 2015-2016, Johan Alvarez <llstarscreamll@hotmail.com>
 * @link       https://github.com/llstarscreamll
 */

namespace Page\Functional\Books;

use FunctionalTester;
use llstarscreamll\Core\Models\User;
use App\Models\Reason;

class Index{
    /**
     * La URL del index del módulo.
     *
     * @var  string
     */
    public static $moduleURL = '/books';

    /**
     * La url del home de la app, para cuando el usuario es redirigido cuando
     * no tiene permisos para realizar alguna acción.
     *
     * @var  string
     */
    public static $homeUrl = '/home';

    /**
     * Nombre del módulo.
     *
     * @var  string
     */
    public static $moduleName = 'Libros';
    public static $titleElem = 'h2';
    public static $titleSmallElem = 'h2 small';

    /**
     * El prefijo de los campos de búsqueda en la tabla Index.
     *
     * @var  string
     */
    public static $searchFieldsPrefix;

    /**
     * El selector de la tabla donde se listan los registros.
     *
     * @var  string
     */
    public static $table = '.table.table-hover';

    /**
     * El mensaje mostrado al usuario cuando no tiene los permisos para realizar
     * alguna acción.
     *
     * @var  string
     */
    public static $badPermissionsMsg = 'No tienes permisos para realizar esta acción.';
    public static $badPermissionsMsgElem = '.alert.alert-warning';

    /**
     * El botón de restaurar varios registros.
     *
     * @var  string
     */
    public static $restoreManyBtn = 'Restaurar seleccionados';
    public static $restoreManyBtnElem = 'button.btn.btn-default.btn-sm';

    /**
     * El botón de restaurar registro.
     *
     * @var  string
     */
    public static $restoreBtn = 'Restaurar';
    public static $restoreBtnElem = 'button.btn.btn-default.btn-sm';

    /**
     * Mensaje cuando no se encuentran datos.
     *
     * @var  array
     */
    public static $noDataFountMsg = 'No se encontraron registros...';
    public static $noDataFountMsgElem = '.alert.alert-warning';

    /**
     * La info de creación del registro.
     *
     * @var  array
     */
    public static $bookData = array();

    /**
     * Las columnas por defecto a mostrar en la tabla del Index.
     *
     * @var  array
     */
    public static $tableColumns = [
        'id',
        'reason_id',
        'name',
        'author',
        'approved_at',
        'created_at',
    ];

    /**
     * Los campos del formulario de creación.
     *
     * @var  array
     */
    public static $createFormFields = [
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
     *
     * @var  array
     */
    public static $editFormFields = [
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
     *
     * @var  array
     */
    public static $fieldsThatRequieresConfirmation = [
        'unlocking_word'
    ];

    /**
     * Los campos a ocultar.
     *
     * @var  array
     */
    public static $hiddenFields = [
        'unlocking_word',
        'approved_password',
    ];

    /**
     * Los datos del usuario que actúa en los tests.
     *
     * @var  array
     */
    public static $adminUser = [
        'name' => 'Travis Orbin',
        'email' => 'travis.orbin@example.com',
        'password' => '123456',
    ];

    /**
     * @var  FunctionalTester
     */
    protected $functionalTester;

    public function __construct(FunctionalTester $I)
    {
        $this->functionalTester = $I;
        static::$searchFieldsPrefix = config('modules.core.app.search-fields-prefix', 'search');

        // creamos permisos de acceso
        \Artisan::call('db:seed', ['--class' => 'BookPermissionsSeeder']);
        \Artisan::call('db:seed', ['--class' => 'RoleTableSeeder']);
        // creamos usuario admin de prueba
        \Artisan::call('db:seed', ['--class' => 'DefaultUsersTableSeeder']);
        \Artisan::call('db:seed', ['--class' => 'ReasonsTableSeeder']);
        \Artisan::call('db:seed', ['--class' => 'UsersTableSeeder']);

        // damos valores a los atributos para crear un registro
        static::$bookData = [
            'id' => 1,
            'reason_id' => Reason::first(['id'])->id,
            'name' => "Cien Años de Soledad",
            'author' => "Gabo Marquez",
            'genre' => "Ficción",
            'stars' => "4",
            'published_year' => date("Y-m-d"),
            'enabled' => '0',
            'status' => "waiting_confirmation",
            'unlocking_word' => "asdfg",
            'synopsis' => "Esta es una prueba de sinopsis...",
            'approved_at' => date("Y-m-d H:i:s"),
            'approved_by' => User::first(['id'])->id,
            'approved_password' => "123456",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'deleted_at' => null,
        ];
    }

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     *
     * @param    string  $param
     *
     * @return  string
     */
    public static function route($param)
    {
        return static::$moduleURL.$param;
    }

    /**
     * Crea un registro del modelo en la base de datos.
     *
     * @param    FunctionalTester $I
     *
     * @return  int El id del modelo generado
     */
    public static function haveBook(FunctionalTester $I)
    {
        return $I->haveRecord('books', static::$bookData);
    }

    /**
     * Devuelve array con los datos para creación de un registro.
     *
     * @return  array
     */
    public static function getCreateData()
    {
        $data = array();

        foreach (static::$bookData as $key => $value) {
            if (in_array($key, static::$createFormFields)) {
                $data[$key] = $value;
            }
            if (in_array($key, static::$fieldsThatRequieresConfirmation)) {
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
     * @return  array
     */
    public static function getIndexTableData()
    {
        $data = static::$bookData;

        // los datos de las llaves foráneas
        $data['reason_id'] = Reason::find($data['reason_id'])->name;
        $data['approved_by'] = User::find($data['approved_by'])->name;
        
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
     * @return  array
     */
    public static function unsetHiddenFields(array $data)
    {
        $data = !empty($data) ? $data : static::$bookData;

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
     * @param    array  $data
     *
     * @return  array
     */
    public static function unsetConfirmationFields(array $data = [])
    {
        $data = !empty($data) ? $data : static::$bookData;
        $confirmedFields = static::$fieldsThatRequieresConfirmation;
        $requiredField = '';

        // los campos ocultos no deben ser mostrados en la vista de sólo lectura
        foreach ($confirmedFields as $key => $value) {
            $requiredField = $value.'_confirmation';
            if (array_key_exists($requiredField, $data)) {
                unset($data[$requiredField]);
            }
        }

        return $data;
    }
}
