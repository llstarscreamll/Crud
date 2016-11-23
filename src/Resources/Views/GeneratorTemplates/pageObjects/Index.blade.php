<?php
/* @var $gen llstarscreamll\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


namespace Page\Functional\<?= $gen->studlyCasePlural() ?>;

use FunctionalTester;
use <?= config('modules.crud.config.user-model-namespace') ?>;
<?php foreach ($fields as $field) { ?>
<?php if ($field->namespace !== "" && class_basename($field->namespace) !== 'User') { ?>
use {!! $field->namespace !!};
<?php } ?>
<?php } ?>

class <?= $test ?>
{
    /**
     * La URL del index del módulo.
     *
     * @var string
     */
    public static $moduleURL = '/<?= $gen->route() ?>';

    /**
     * La url del home de la app, para cuando el usuario es redirigido cuando
     * no tiene permisos para realizar alguna acción.
     *
     * @var string
     */
    public static $homeUrl = '/home';

    /**
     * Nombre del módulo.
     *
     * @var string
     */
    public static $moduleName = '{!!$request->get('plural_entity_name')!!}';
    public static $titleElem = '<?= config('modules.crud.uimap.module-title-selector') ?>';
    public static $titleSmallElem = '<?= config('modules.crud.uimap.module-title-small-selector') ?>';

    /**
     * El prefijo de los campos de búsqueda en la tabla Index.
     *
     * @var string
     */
    public static $searchFieldsPrefix;

    /**
     * El selector de la tabla donde se listan los registros.
     *
     * @var string
     */
    public static $table = '<?= config('modules.crud.uimap.index-table-selector') ?>';

    /**
     * El mensaje mostrado al usuario cuando no tiene los permisos para realizar
     * alguna acción.
     *
     * @var string
     */
    public static $badPermissionsMsg = '<?= config('modules.crud.config.permissions-middleware-msg') ?>';
    public static $badPermissionsMsgElem = '.alert.alert-warning';

<?php if ($gen->hasDeletedAtColumn($fields)) { ?>
    /**
     * El botón de restaurar varios registros.
     *
     * @var string
     */
    public static $restoreManyBtn = 'Restaurar seleccionados';
    public static $restoreManyBtnElem = 'button.btn.btn-default.btn-sm';

    /**
     * El botón de restaurar registro.
     *
     * @var string
     */
    public static $restoreBtn = 'Restaurar';
    public static $restoreBtnElem = 'button.btn.btn-default.btn-sm';
<?php } ?>

    /**
     * Mensaje cuando no se encuentran datos.
     *
     * @var array
     */
    public static $noDataFountMsg = 'No se encontraron registros...';
    public static $noDataFountMsgElem = '<?= config('modules.crud.uimap.alert-warning-selector') ?>';

    /**
     * La info de creación del registro.
     *
     * @var array
     */
    public static $<?= $gen->modelVariableName() ?>Data = array();

    /**
     * Las columnas por defecto a mostrar en la tabla del Index.
     *
     * @var array
     */
    public static $tableColumns = [
<?php foreach ($fields as $field) { ?>
<?php if ($field->on_index_table && !$field->hidden) { ?>
        '<?= $field->name ?>',
<?php } ?>
<?php } ?>
    ];

    /**
     * Los campos del formulario de creación.
     *
     * @var array
     */
    public static $createFormFields = [
<?php foreach ($fields as $field) { ?>
<?php if ($field->on_create_form) { ?>
        '<?= $field->name ?>',
<?php } ?>
<?php } ?>
    ];

     /**
     * Los campos del formulario de edición.
     *
     * @var array
     */
    public static $editFormFields = [
<?php foreach ($fields as $field) { ?>
<?php if ($field->on_update_form) { ?>
        '<?= $field->name ?>',
<?php } ?>
<?php } ?>
    ];

    /**
     * Los campos que requieren confirmación.
     *
     * @var array
     */
    public static $fieldsThatRequieresConfirmation = [
<?php foreach ($fields as $field) { ?>
<?php if (strpos($field->validation_rules, 'confirmed')) { ?>
        '<?= $field->name ?>'
<?php } ?>
<?php } ?>
    ];

    /**
     * Los campos a ocultar.
     *
     * @var array
     */
    public static $hiddenFields = [
<?php foreach ($fields as $field) { ?>
<?php if ($field->hidden) { ?>
        '<?= $field->name ?>',
<?php } ?>
<?php } ?>
    ];

    /**
     * Los datos del usuario que actúa en los tests.
     *
     * @var array
     */
    public static $adminUser = [
        'name' => 'Travis Orbin',
        'email' => 'travis.orbin@example.com',
        'password' => '123456',
    ];

    /**
     * @var FunctionalTester
     */
    protected $functionalTester;

    public function __construct(FunctionalTester $I)
    {
        $this->functionalTester = $I;
        static::$searchFieldsPrefix = <?= $gen->getSearchFieldsPrefixConfigString() ?>;

        // creamos permisos de acceso
        \Artisan::call('db:seed', ['--class' => '<?= $gen->modelClassName() ?>PermissionsSeeder']);
        \Artisan::call('db:seed', ['--class' => '<?= config('modules.crud.config.test-roles-seeder-class') ?>']);
        // creamos usuario admin de prueba
        \Artisan::call('db:seed', ['--class' => '<?= config('modules.crud.config.test-users-seeder-class') ?>']);
<?php foreach ($fields as $field) { ?>
<?php if ($field->namespace) { ?>
        \Artisan::call('db:seed', ['--class' => '<?= $gen->getTableSeederClassName($field) ?>']);
<?php } ?>
<?php } ?>

        // damos valores a los atributos para crear un registro
        static::$<?= $gen->modelVariableName() ?>Data = [
<?php foreach ($fields as $field) { ?>
<?php if ($field->type == 'tinyint') { ?>
<?php if ($field->testData == 'false' || $field->testData == '0') { ?>
            '<?= $field->name ?>' => '0',
<?php } elseif ($field->testData == 'true' || $field->testData == '1') { ?>
            '<?= $field->name ?>' => true,
<?php } ?>
<?php } else { ?>
            '<?= $field->name ?>' => {!! $field->namespace == '' ? $field->testData : class_basename($field->namespace)."::first(['id'])->id" !!},
<?php } ?>
<?php } ?>
        ];
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
    public static function have<?= $gen->modelClassName() ?>(FunctionalTester $I)
    {
        return $I->haveRecord('<?= $gen->table_name ?>', static::$<?= $gen->modelVariableName() ?>Data);
    }

    /**
     * Devuelve array con los datos para creación de un registro.
     *
     * @return array
     */
    public static function getCreateData()
    {
        $data = array();

        foreach (static::$<?= $gen->modelVariableName() ?>Data as $key => $value) {
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
     * @return array
     */
    public static function getIndexTableData()
    {
        $data = static::$<?= $gen->modelVariableName() ?>Data;

        // los datos de las llaves foráneas
<?php foreach ($fields as $field) { ?>
<?php if ($field->namespace) { ?>
        $data['<?= $field->name ?>'] = <?= class_basename($field->namespace) ?>::find($data['<?= $field->name ?>'])->name;
<?php } ?>
<?php } ?>
        
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
        $data = !empty($data) ? $data : static::$<?= $gen->modelVariableName() ?>Data;

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
        $data = !empty($data) ? $data : static::$<?= $gen->modelVariableName() ?>Data;
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
