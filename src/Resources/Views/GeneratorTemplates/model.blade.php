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
     * La tabla asociada al modelo.
     * @var string
     */
    public $table = '{{$gen->table_name}}';

    /**
     * Los atributos que SI son asignables.
     * @var array
     */
    public $fillable = [
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
    public $guarded = ['id', 'created_at', 'updated_at'@if($hasSoftDelete), 'deleted_at'@endif];

    /**
     * Indica si Eloquent debe gestionar los timestamps del modelo.
     * @var bool
     */
    public $timestamps = true;
    
    /**
     * Los atributos que deben ser convertidos a fechas.
     * @var array
     */
    public $dates = ['created_at', 'updated_at'@if($hasSoftDelete), "deleted_at"@endif];

    /**
     * El formato de almacenamiento de las columnas de tipo fecha del modelo.
     * @var string
     */
    public $dateFormat = 'Y-m-d H:i:s';

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
        $request->input('{{$field->name}}') and $query->where({!! $gen->getConditionStr($field) !!});
@endforeach

        // ordenamos los resultados
        $request->input('sort') and $query->orderBy($request->input('sort'), $request->input('sortType', 'asc'));

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
         $type = \DB::select( \DB::raw("SHOW COLUMNS FROM $table WHERE Field = '$column'") )[0]->Type;

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
         $type = \DB::select( \DB::raw("SHOW COLUMNS FROM $table WHERE Field = '$column'") )[0]->Type;

         preg_match('/^enum\((.*)\)$/', $type, $matches);

         $enum = '';

         foreach( explode(',', $matches[1]) as $value ){
           $v = trim( $value, "'" );
           $enum .= $v.',';
         }

         return $enum;
    }
@endif

}