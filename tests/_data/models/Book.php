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

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    /**
     * El nombre de la conexión a la base de datos del modelo.
     *
     * @var  string
     */
    //protected $connection = 'connection-name';
    
    /**
     * La tabla asociada al modelo.
     * @var  string
     */
    protected $table = 'books';

    /**
     * La llave primaria del modelo.
     * @var  string
     */
    protected $primaryKey = 'id';

    /**
     * Los atributos que SI son asignables.
     * @var  array
     */
    protected $fillable = [
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
        'approved_at',
        'approved_by',
        'approved_password',
    ];

    /**
     * Los atributos que NO son asignables.
     * @var  array
     */
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * Los atributos ocultos al usuario.
     * @var  array
     */
    protected $hidden = [
        'unlocking_word',
        'approved_password',
    ];

    /**
     * Indica si Eloquent debe gestionar los timestamps del modelo.
     * @var  bool
     */
    public $timestamps = true;
    
    /**
     * Los atributos que deben ser convertidos a fechas.
     * @var  array
     */
    protected $dates = ['created_at', 'updated_at', "deleted_at"];

    /**
     * El formato de almacenamiento de las columnas de tipo fecha del modelo.
     * @var  string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * Los valores de la columna status que es de tipo enum, esto para los casos
     * en que sea utilizada una base de datos sqlite, pues sqlite no soporta campos de
     * tipo enum.
     * @var  string
     */
    static $statusColumnEnumValues = "enum('setting_documents','waiting_confirmation','reviewing','approved')";

    /**
     * La relación con App\Models\Reason
     * @return  object
     */
    public function reason()
    {
        return $this->belongsTo('App\Models\Reason', 'reason_id');
    }
    /**
     * La relación con llstarscreamll\Core\Models\User
     * @return  object
     */
    public function approvedBy()
    {
        return $this->belongsTo('llstarscreamll\Core\Models\User', 'approved_by');
    }
    
    /**
     * Realiza la consulta de los datos del modelo según lo que el usuario especifique.
     * @param    Illuminate\Http\Request $request
     * @return  Illuminate\Support\Collection
     */
    public static function findRequested($request)
    {
        $query = Book::query();

        // buscamos basados en los datos que señale el usuario
        $request->get('id') and $query->where('id', $request->get('id'));

        $request->get('reason_id') and $query->whereIn('reason_id', $request->get('reason_id'));

        $request->get('name') and $query->where('name', 'like', '%'.$request->get('name').'%');

        $request->get('author') and $query->where('author', 'like', '%'.$request->get('author').'%');

        $request->get('genre') and $query->where('genre', 'like', '%'.$request->get('genre').'%');

        $request->get('stars') and $query->where('stars', $request->get('stars'));

        $request->get('published_year')['informative'] and $query->whereBetween('published_year', [
            $request->get('published_year')['from'],
            $request->get('published_year')['to']
        ]);

        $request->get('enabled_true') and $query->where('enabled', true);
        ($request->get('enabled_false') && !$request->has('enabled_true')) and $query->where('enabled', false);
        ($request->get('enabled_false') && $request->has('enabled_true')) and $query->orWhere('enabled', false);

        $request->get('status') and $query->whereIn('status', $request->get('status'));

        $request->get('unlocking_word') and $query->where('unlocking_word', 'like', '%'.$request->get('unlocking_word').'%');

        $request->get('synopsis') and $query->where('synopsis', 'like', '%'.$request->get('synopsis').'%');

        $request->get('approved_at')['informative'] and $query->whereBetween('approved_at', [
            $request->get('approved_at')['from'],
            $request->get('approved_at')['to']
        ]);

        $request->get('approved_by') and $query->whereIn('approved_by', $request->get('approved_by'));

        $request->get('approved_password') and $query->where('approved_password', 'like', '%'.$request->get('approved_password').'%');

        $request->get('created_at')['informative'] and $query->whereBetween('created_at', [
            $request->get('created_at')['from'],
            $request->get('created_at')['to']
        ]);

        $request->get('updated_at')['informative'] and $query->whereBetween('updated_at', [
            $request->get('updated_at')['from'],
            $request->get('updated_at')['to']
        ]);

        $request->get('deleted_at')['informative'] and $query->whereBetween('deleted_at', [
            $request->get('deleted_at')['from'],
            $request->get('deleted_at')['to']
        ]);

        // registros en papelera
        $request->has('trashed_records') and $query->{$request->get('trashed_records')}();
        // ordenamos los resultados
        $request->get('sort') and $query->orderBy($request->get('sort'), $request->get('sortType', 'asc'));

        !$request->has('sort') and $query->orderBy('created_at', 'desc');

        // paginamos los resultados
        return $query->paginate(15);
    }
    
    /**
     * Las reglas de validación para el modelo.
     * @param    string|array $attributes Las reglas de los atributos que se quiere devolver
     * @param    \Illuminate\Http\Request $request
     * @param    string $route La ruta desde donde se quiere obtener las reglas
     * @return  array
     */
    public static function validationRules($attributes = null, $request, $route = null)
    {
        $rules = [
            'id' => 'numeric',
            'reason_id' => 'required|numeric|exists:reasons,id',
            'name' => 'required|string',
            'author' => 'required|string',
            'genre' => 'required|string',
            'stars' => 'required|numeric',
            'published_year' => 'required|date_format:Y-m-d',
            'enabled' => 'boolean',
            'status' => 'required|alpha_dash|in:'.self::getEnumValuesString('books', 'status').'',
            'unlocking_word' => 'required|confirmed',
            'synopsis' => 'string',
            'approved_at' => '',
            'approved_by' => '',
            'approved_password' => '',
            'created_at' => '',
            'updated_at' => '',
            'deleted_at' => '',
        ];

        // hacemos los cambios necesarios a las reglas cuando la ruta sea update
        if ($route == 'update') {
        }

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

    /**
     * Devuelve array con los posibles valores de una columna de tipo "enum" de la base de datos.
     * @param    string $table
     * @param    string $column
     * @return  array
     */
    public static function getEnumValuesArray($table, $column)
    {
        $type = static::getColumnEnumValuesFromDescQuery($table, $column);

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
     * @param    string $table
     * @param    string $column
     * @return  array
     */
    public static function getEnumValuesString($table, $column)
    {
        $type = static::getColumnEnumValuesFromDescQuery($table, $column);

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
     * @return  string
     */
    public static function getColumnEnumValuesFromDescQuery($table, $column)
    {
        $type = '';

        if (static::getDatabaseConnectionDriver() == 'mysql') {
            $type = \DB::select( \DB::raw("SHOW COLUMNS FROM ".static::getDatabaseTablesPrefix()."$table WHERE Field = '$column'") )[0]->Type;
        } else {
            $type = static::${$column.'ColumnEnumValues'};
        }

        return $type;
    }

    /**
     * Devuelve string del driver de la conexión a la base de datos.
     * @return  string El nombre del driver de la conexión a la base de datos.
     */
    public static function getDatabaseConnectionDriver()
    {
        return config('database.connections.'.config('database.default').'.driver');
    }

    /**
     * Devuelve string del prefijo de las tablas de la base de datos.
     * @return  string El nombre del driver de la conexión a la base de datos.
     */
    public static function getDatabaseTablesPrefix()
    {
        return config('database.connections.'.config('database.default').'.prefix');
    }

}
