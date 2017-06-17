<?php
/* @var $crud App\Containers\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $crud->getClassCopyRightDocBlock() ?>


namespace <?= config('modules.crud.config.parent-app-namespace') ?>\Models;

use Illuminate\Database\Eloquent\Model;
<?php if (($hasSoftDelete = $crud->hasDeletedAtColumn($fields))) { ?>
use Illuminate\Database\Eloquent\SoftDeletes;
<?php } ?>
use Illuminate\Support\Collection;
<?php if ($crud->areEnumFields($fields)) { ?>
use llstarscreamll\Core\Traits\EnumValues;
<?php } ?>

/**
 * Clase <?= $crud->modelClassName()."\n" ?>
 *
 * @author <?= config('modules.crud.config.author') ?> <<?= config('modules.crud.config.author_email') ?>>
 */
class <?= $crud->modelClassName() ?> extends Model
{
<?php if ($hasSoftDelete) { ?>
    use SoftDeletes;
<?php } ?>
<?php if ($crud->areEnumFields($fields)) { ?>
    use EnumValues;
<?php } ?>

    /**
     * El nombre de la conexión a la base de datos del modelo.
     *
     * @var string
     */
    // protected $connection = 'connection-name';
    
    /**
     * La tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = '<?= $crud->table_name ?>';

    /**
     * La llave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = '<?= $crud->getPrimaryKey($fields) ?>';

    /**
     * Los atributos asignables (mass assignable).
     *
     * @var array
     */
    protected $fillable = [
<?php foreach ($fields as $field) { ?>
<?php if ($field->fillable) { ?>
        '<?= $field->name ?>',
<?php } ?>
<?php } ?>
    ];

    /**
     * Los atributos ocultos al usuario.
     *
     * @var array
     */
    protected $hidden = [
<?php foreach ($fields as $field) { ?>
<?php if ($field->hidden) { ?>
        '<?= $field->name ?>',
<?php } ?>
<?php } ?>
    ];

    /**
     * Indica si Eloquent debe gestionar los timestamps en el modelo.
     *
     * @var bool
     */
    public $timestamps = <?= $crud->hasLaravelTimestamps($fields) ? 'true' : 'false' ?>;
    
    /**
     * Los atributos que deben ser convertidos a fechas (Carbon).
     *
     * @var array
     */
    protected $dates = [
<?php foreach ($fields as $field) { ?>
<?php if (in_array($field->type, ['datetime', 'timestamp'])) { ?>
        '<?= $field->name ?>',
<?php } ?>
<?php } ?>
    ];

    /**
     * El formato de almacenamiento de las columnas de tipo fecha del modelo.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * Los "accessors" a adjuntar al modelo cuando sea convertido a array o Json.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Casting de atributos a los tipos de datos nativos.
     *
     * @var array
     */
    public $casts = [
<?php foreach ($fields as $field) { ?>
<?php if (!in_array($field->type, ['datetime', 'timestamp', 'date'])) { ?>
        '<?= $field->name ?>' => '<?= $crud->getFieldTypeCast($field) ?>',
<?php } ?>
<?php } ?>
    ];

<?php foreach ($fields as $field) { ?>
<?php if ($field->type == 'enum') { ?>
    /**
     * Los valores de la columna <?= $field->name ?> que es de tipo enum, esto
     * para los casos en que sea utilizada una base de datos sqlite, pues sqlite
     * no soporta campos de tipo enum.
     *
     * @var string
     */
    protected static $<?= $field->name ?>ColumnEnumValues = "<?=$crud->getMysqlTableColumnEnumValues($field->name)?>";
<?php } ?>
<?php } ?>

<?php foreach ($fields as $field) { ?>
<?php if (!empty($field->relation)) { ?>
    /**
     * La relación con <?= $field->namespace.".\n" ?>
     */
    public function <?=  $crud->getFunctionNameRelationFromField($field)  ?>()
    {
        return $this-><?= $field->relation ?>('<?= $field->namespace ?>', '<?= $field->name ?>');
    }
<?php } ?>
<?php } ?>
}
