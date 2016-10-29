<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


namespace <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Models;

use Illuminate\Database\Eloquent\Model;
@if(($hasSoftDelete = $gen->hasDeletedAtColumn($fields)))
use Illuminate\Database\Eloquent\SoftDeletes;
@endif
use Illuminate\Support\Collection;

class {{$gen->modelClassName()}} extends Model
{
@if($hasSoftDelete)
    use SoftDeletes;
@endif

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
    protected $table = '{{$gen->table_name}}';

    /**
     * La llave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = '{{$gen->getPrimaryKey($fields)}}';

    /**
     * Los atributos que SI son asignables.
     *
     * @var array
     */
    protected $fillable = [
@foreach($fields as $field)
@if($field->fillable)
        '{{$field->name}}',
@endif
@endforeach
    ];

    /**
     * Los atributos que NO son asignables.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'@if($hasSoftDelete), 'deleted_at'@endif];

    /**
     * Los atributos ocultos al usuario.
     *
     * @var array
     */
    protected $hidden = [
@foreach($fields as $field)
@if($field->hidden)
        '{{$field->name}}',
@endif
@endforeach
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
    protected $dates = ['created_at', 'updated_at'@if($hasSoftDelete), "deleted_at"@endif];

    /**
     * El formato de almacenamiento de las columnas de tipo fecha del modelo.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

@foreach ($fields as $field)
@if($field->type == 'enum')
    /**
     * Los valores de la columna {{$field->name}} que es de tipo enum, esto para los casos
     * en que sea utilizada una base de datos sqlite, pues sqlite no soporta campos de
     * tipo enum.
     *
     * @var string
     */
    static ${{$field->name}}ColumnEnumValues = "{!!$gen->getMysqlTableColumnEnumValues($field->name)!!}";
@endif
@endforeach

@foreach ($fields as $field)
@if (!empty($field->relation))
    /**
     * La relación con {{$field->namespace}}
     *
     * @return object
     */
    public function {{ $gen->getFunctionNameRelationFromField($field) }}()
    {
        return $this-><?= $field->relation ?>('{{$field->namespace}}', '{{$field->name}}');
    }

@endif
@endforeach
    /**
     * Realiza consulta de los datos según lo que el usuario especifique.
     *
     * @param  Illuminate\Support\Collection $input
     *
     * @return Illuminate\Support\Collection
     */
    public static function findRequested(Collection $input)
    {
        $query = {{$gen->modelClassName()}}::query();

        // buscamos basados en los datos que señale el usuario
@foreach ( $fields as $field )
@if(!$field->hidden)
@if($field->type == 'tinyint')
        $input->get('{{$field->name}}_true') && $query->where({!! $gen->getConditionStr($field, 'true') !!});
        ($input->get('{{$field->name}}_false') && !$input->has('{{$field->name}}_true')) && $query->where({!! $gen->getConditionStr($field, 'false') !!});
        ($input->get('{{$field->name}}_false') && $input->has('{{$field->name}}_true')) && $query->orWhere({!! $gen->getConditionStr($field, 'false') !!});

@elseif($field->type == 'enum' || $field->key == 'MUL' || $field->key == 'PRI')
<?php $name = $field->name == 'id' ? 'ids' : $field->name ?>
        $input->get('{{$name}}') && $query->whereIn({!! $gen->getConditionStr($field) !!});

@elseif($field->type == 'date' || $field->type == 'timestamp' || $field->type == 'datetime')
        $input->get('{{$field->name}}')['informative'] && $query->whereBetween('{{$field->name}}', [
            $input->get('{{$field->name}}')['from'],
            $input->get('{{$field->name}}')['to']
        ]);

@else
        $input->get('{{$field->name}}') && $query->where({!! $gen->getConditionStr($field) !!});

@endif
@endif
@endforeach
@if($hasSoftDelete)
        // registros en papelera
        $input->has('trashed_records') && $query->{$input->get('trashed_records')}();
@endif
        // ordenamos los resultados
        $query->orderBy($input->get('sort', 'created_at'), $input->get('sortType', 'desc'));

        // paginamos los resultados
        return $query;
    }

@if($gen->areEnumFields($fields))
    /**
     * Devuelve array con los posibles valores de una columna de tipo "enum" de la base de datos.
     *
     * @param  string $column
     * @param  string $table
     *
     * @return array
     */
    public function getEnumValuesArray(string $column, string $table = '')
    {
        $table = !empty($table) ? $table : $this->table;

        $type = $this->getColumnEnumValuesFromDescQuery($column, $table);

        preg_match('/^enum\((.*)\)$/', $type, $matches);

        $enum = array();

        foreach (explode(',', $matches[1]) as $value) {
            $v = trim($value, "'");
            $enum = array_add($enum, $v, $v);
        }

        return $enum;
    }

    /**
     * Devuelve string con los posibles valores de una columna de tipo "enum" de
     * la base de datos separados por coma.
     *
     * @param  string $column
     * @param  string $table
     *
     * @return array
     */
    public function getEnumValuesString(string $column, string $table = '')
    {
        $table = !empty($table) ? $table : $this->table;
        
        $type = $this->getColumnEnumValuesFromDescQuery($column, $table);

        preg_match('/^enum\((.*)\)$/', $type, $matches);

        $enum = '';

        foreach (explode(',', $matches[1]) as $value) {
            $v = trim($value, "'");
            $enum .= $v.',';
        }

        return $enum;
    }

    /**
     * Obtiene los valores de una columna de tipo enum si la base de datos es
     * mysql, si no, devuelve los valores enum staticos dados en la creación
     * del modelo.
     *
     * @return string
     */
    public function getColumnEnumValuesFromDescQuery(string $column, string $table = '')
    {
        $table = !empty($table) ? $table : $this->table;
        
        $type = static::${$column.'ColumnEnumValues'};

        if ($this->getDatabaseConnectionDriver() == 'mysql') {
            $type = \DB::select(
                \DB::raw(
                    "SHOW COLUMNS FROM ".
                    $this->getDatabaseTablesPrefix().
                    "$table WHERE Field = '$column'"
                )
            )[0]->Type;
        }

        return $type;
    }

    /**
     * Devuelve string del driver de la conexión a la base de datos.
     *
     * @return string El nombre del driver de la conexión a la base de datos.
     */
    public function getDatabaseConnectionDriver()
    {
        return config('database.connections.'.config('database.default').'.driver');
    }

    /**
     * Devuelve string del prefijo de las tablas de la base de datos.
     *
     * @return string El nombre del driver de la conexión a la base de datos.
     */
    public function getDatabaseTablesPrefix()
    {
        return config('database.connections.'.config('database.default').'.prefix');
    }
@endif
}
