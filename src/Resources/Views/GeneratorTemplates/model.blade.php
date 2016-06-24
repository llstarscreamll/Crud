<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
<?='<?php'?>

namespace {{config('llstarscreamll.CrudGenerator.config.parent-app-namespace')}}\Models;

use Illuminate\Database\Eloquent\Model;
@if(($hasSoftDelete = $gen->hasDeletedAtColumn($fields)))
use Illuminate\Database\Eloquent\SoftDeletes;
@endif
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
     * @var string
     */
    protected $table = '{{$gen->table_name}}';

    /**
     * La llave primaria del modelo.
     * @var string
     */
    protected $primaryKey = '{{$gen->getPrimaryKey($fields)}}';

    /**
     * Los atributos que SI son asignables.
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
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'@if($hasSoftDelete), 'deleted_at'@endif];

    /**
     * Los atributos ocultos al usuario.
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
     * @var bool
     */
    public $timestamps = true;
    
    /**
     * Los atributos que deben ser convertidos a fechas.
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'@if($hasSoftDelete), "deleted_at"@endif];

    /**
     * El formato de almacenamiento de las columnas de tipo fecha del modelo.
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

@foreach ($fields as $field)
@if($field->type == 'enum')
    /**
     * Los valores de la columna {{$field->name}} que es de tipo enum, esto para los casos
     * en que sea utilizada una base de datos sqlite, pues sqlite no soporta campos de
     * tipo enum.
     * @var string
     */
    static ${{$field->name}}ColumnEnumValues = "{!!$gen->getMysqlTableColumnEnumValues($field->name)!!}";
@endif
@endforeach

@foreach ($fields as $field)
@if (!empty($field->relation))
    /**
     * La relación con {{$field->namespace}}
     * @return object
     */
    public function {{ $gen->getFunctionNameRelationFromField($field) }}()
    {
        return $this->belongsTo('{{$field->namespace}}', '{{$field->name}}');
    }
@endif
@endforeach
    
    /**
     * Realiza la consulta de los datos del modelo según lo que el usuario especifique.
     * @param  Illuminate\Http\Request $request
     * @return Illuminate\Support\Collection
     */
    public static function findRequested($request)
    {
        $query = {{$gen->modelClassName()}}::query();

        // buscamos basados en los datos que señale el usuario
@foreach ( $fields as $field )
@if($field->type == 'tinyint')
        $request->get('{{$field->name}}_true') and $query->where({!! $gen->getConditionStr($field, 'true') !!});
        $request->get('{{$field->name}}_false') and $query->orWhere({!! $gen->getConditionStr($field, 'false') !!});

@elseif($field->type == 'enum' || $field->key == 'MUL')
        $request->get('{{$field->name}}') and $query->whereIn({!! $gen->getConditionStr($field) !!});

@elseif($field->type == 'date' || $field->type == 'timestamp' || $field->type == 'datetime')
        $request->get('{{$field->name}}')['informative'] and $query->whereBetween('{{$field->name}}', [
            $request->get('{{$field->name}}')['from'],
            $request->get('{{$field->name}}')['to']
        ]);

@else
        $request->get('{{$field->name}}') and $query->where({!! $gen->getConditionStr($field) !!});

@endif
@endforeach
        // ordenamos los resultados
        $request->get('sort') and $query->orderBy($request->get('sort'), $request->get('sortType', 'asc'));

        // paginamos los resultados
        return $query->paginate(15);
    }
    
    /**
     * Las reglas de validación para el modelo.
     * @param  string|array $attributes Las reglas de los atributos que se quiere devolver
     * @return array
     */
    public static function validationRules( $attributes = null )
    {
        $rules = [
@foreach ( $fields as $field )
        '{{$field->name}}' => '{!!$field->validation_rules!!}',
@endforeach
        ];

        // no se dieron atributos
        if (! $attributes) {
            return $rules;
        }

        // se dio un atributo nada mas
        if (!is_array($attributes)) {
            return [ $attributes => $rules[$attributes] ];
        }

        // se dio una lista de atributos
        $newRules = [];
        foreach ( $attributes as $attr ) {
            $newRules[$attr] = $rules[$attr];
        }

        return $newRules;
    }

@if($gen->areEnumFields($fields))
    /**
     * Devuelve array con los posibles valores de una columna de tipo "enum" de la base de datos.
     * @param  string $table
     * @param  string $column
     * @return array
     */
    public static function getEnumValuesArray($table, $column)
    {
        $type = self::getColumnEnumValuesFromDescQuery($table, $column);

        preg_match('/^enum\((.*)\)$/', $type, $matches);

        $enum = array();

        foreach( explode(',', $matches[1]) as $value ){
            $v = trim( $value, "'" );
            $enum = array_add($enum, $v, $v);
        }

        return $enum;
    }

    /**
     * Devuelve string con los posibles valores de una columna de tipo "enum" de la base de datos
     * separados por coma.
     * @param  string $table
     * @param  string $column
     * @return array
     */
    public static function getEnumValuesString($table, $column)
    {
        $type = self::getColumnEnumValuesFromDescQuery($table, $column);

        preg_match('/^enum\((.*)\)$/', $type, $matches);

        $enum = '';

        foreach( explode(',', $matches[1]) as $value ){
            $v = trim( $value, "'" );
            $enum .= $v.',';
        }

        return $enum;
    }

    /**
     * Obtiene los valores de una columna de tipo enum si la base de datos es mysql, si no,
     * devuelve los valores enum staticos dados en la creación del modelo.
     * @return string
     */
    public static function getColumnEnumValuesFromDescQuery($table, $column)
    {
        $type = '';

        if (self::getDatabaseConnectionDriver() == 'mysql') {
            $type = \DB::select( \DB::raw("SHOW COLUMNS FROM $table WHERE Field = '$column'") )[0]->Type;
        } else {
            $type = self::${$column.'ColumnEnumValues'};
        }

        return $type;
    }

    /**
     * Devuelve string del driver de la conexión a la base de datos.
     * @return string El nombre del driver de la conexión a la base de datos.
     */
    public static function getDatabaseConnectionDriver()
    {
        return config('database.connections.'.config('database.default').'.driver');
    }
@endif

}
