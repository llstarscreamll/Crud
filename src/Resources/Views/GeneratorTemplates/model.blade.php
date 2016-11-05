<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


namespace <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Models;

use Illuminate\Database\Eloquent\Model;
<?php if (($hasSoftDelete = $gen->hasDeletedAtColumn($fields))) { ?>
use Illuminate\Database\Eloquent\SoftDeletes;
<?php } ?>
use Illuminate\Support\Collection;
<?php if ($gen->areEnumFields($fields)) { ?>
use llstarscreamll\Core\Traits\EnumValues;
<?php } ?>

class <?= $gen->modelClassName() ?> extends Model
{
<?php if ($hasSoftDelete) { ?>
    use SoftDeletes;
<?php } ?>
<?php if ($gen->areEnumFields($fields)) { ?>
    use EnumValues;
<?php } ?>

    /**
     * El nombre de la conexión a la base de datos del modelo.
     *
     * @var string
     */
    //protected $connection = 'connection-name';
    
    /**
     * La tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = '<?= $gen->table_name ?>';

    /**
     * La llave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = '<?= $gen->getPrimaryKey($fields) ?>';

    /**
     * Los atributos que SI son asignables.
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
     * Los atributos que NO son asignables.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'<?= $hasSoftDelete ? ", 'deleted_at'" : null ?>];

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
     * Indica si Eloquent debe gestionar los timestamps del modelo.
     *
     * @var bool
     */
    public $timestamps = true;
    
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
     * Los "accessors" a adjuntar al modelo cuando sea convertido a array.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Mapeo de casting de atributos a los tipos de datos nativos.
     *
     * @var array
     */
    public $casts = [
<?php foreach ($fields as $field) { ?>
<?php if (!in_array($field->type, ['datetime', 'timestamp', 'date'])) { ?>
        '<?= $field->name ?>' => '<?= $gen->getFieldTypeCast($field) ?>',
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
    protected static $<?= $field->name ?>ColumnEnumValues = "<?=$gen->getMysqlTableColumnEnumValues($field->name)?>";
<?php } ?>
<?php } ?>

<?php foreach ($fields as $field) { ?>
<?php if (!empty($field->relation)) { ?>
    /**
     * La relación con <?= $field->namespace.".\n" ?>
     */
    public function <?=  $gen->getFunctionNameRelationFromField($field)  ?>()
    {
        return $this-><?= $field->relation ?>('<?= $field->namespace ?>', '<?= $field->name ?>');
    }
<?php } ?>
<?php } ?>
}
