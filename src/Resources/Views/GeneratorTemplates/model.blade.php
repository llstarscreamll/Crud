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
    protected $dates = ['created_at', 'updated_at'<?= $hasSoftDelete ? ", 'deleted_at'" : null ?>];

    /**
     * El formato de almacenamiento de las columnas de tipo fecha del modelo.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

<?php foreach ($fields as $field) { ?>
<?php if ($field->type == 'enum') { ?>
    /**
     * Los valores de la columna <?= $field->name ?> que es de tipo enum, esto para
     * los casos en que sea utilizada una base de datos sqlite, pues sqlite no
     * soporta campos de tipo enum.
     *
     * @var string
     */
    protected static $<?= $field->name ?>ColumnEnumValues = "<?=$gen->getMysqlTableColumnEnumValues($field->name)?>";
<?php } ?>
<?php } ?>

<?php foreach ($fields as $field) { ?>
<?php if (!empty($field->relation)) { ?>
    /**
     * La relación con <?= $field->namespace ?>
     *
     * @return object
     */
    public function <?=  $gen->getFunctionNameRelationFromField($field)  ?>()
    {
        return $this-><?= $field->relation ?>('<?= $field->namespace ?>', '<?= $field->name ?>');
    }

<?php } ?>
<?php } ?>
    /**
     * Realiza consulta de los datos según lo que el usuario especifique.
     *
     * @param  Illuminate\Support\Collection $input
     *
     * @return Illuminate\Support\Collection
     */
    public static function findRequested(Collection $input)
    {
        $query = <?= $gen->modelClassName() ?>::query();

        // buscamos basados en los datos que señale el usuario
<?php foreach ($fields as $field) { ?>
<?php if (!$field->hidden) { ?>
<?php if ($field->type == 'tinyint') { ?>
        $input->get('<?= $field->name ?>_true') && $query->where(<?= $gen->getConditionStr($field, 'true') ?>);
        ($input->get('<?= $field->name ?>_false') && !$input->has('<?= $field->name ?>_true')) && $query->where(<?= $gen->getConditionStr($field, 'false') ?>);
        ($input->get('<?= $field->name ?>_false') && $input->has('<?= $field->name ?>_true')) && $query->orWhere(<?= $gen->getConditionStr($field, 'false') ?>);

<?php } elseif ($field->type == 'enum' || $field->key == 'MUL' || $field->key == 'PRI') { ?>
<?php $name = $field->name == 'id' ? 'ids' : $field->name ?>
        $input->get('<?= $name ?>') && $query->whereIn(<?= $gen->getConditionStr($field) ?>);

<?php } elseif ($field->type == 'date' || $field->type == 'timestamp' || $field->type == 'datetime') { ?>
        $input->get('<?= $field->name ?>')['informative'] && $query->whereBetween('<?= $field->name ?>', [
            $input->get('<?= $field->name ?>')['from'],
            $input->get('<?= $field->name ?>')['to']
        ]);

<?php } else { ?>
        $input->get('<?= $field->name ?>') && $query->where(<?= $gen->getConditionStr($field) ?>);

<?php } ?>
<?php } ?>
<?php } ?>
<?php if ($hasSoftDelete) { ?>
        // registros en papelera
        $input->has('trashed_records') && $query->{$input->get('trashed_records')}();
<?php } ?>
        // ordenamos los resultados
        $query->orderBy($input->get('sort', 'created_at'), $input->get('sortType', 'desc'));

        return $query;
    }
}
