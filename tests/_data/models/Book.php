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
use Illuminate\Support\Collection;
use llstarscreamll\Core\Traits\EnumValues;

/**
 * Clase Book
 *
 * @author  Johan Alvarez <llstarscreamll@hotmail.com>
 */
class Book extends Model
{
    use SoftDeletes;
    use EnumValues;

    /**
     * El nombre de la conexión a la base de datos del modelo.
     *
     * @var  string
     */
    // protected $connection = 'connection-name';
    
    /**
     * La tabla asociada al modelo.
     *
     * @var  string
     */
    protected $table = 'books';

    /**
     * La llave primaria del modelo.
     *
     * @var  string
     */
    protected $primaryKey = 'id';

    /**
     * Los atributos asignables (mass assignable).
     *
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
     * Los atributos ocultos al usuario.
     *
     * @var  array
     */
    protected $hidden = [
        'unlocking_word',
        'approved_password',
    ];

    /**
     * Indica si Eloquent debe gestionar los timestamps en el modelo.
     *
     * @var  bool
     */
    public $timestamps = true;
    
    /**
     * Los atributos que deben ser convertidos a fechas (Carbon).
     *
     * @var  array
     */
    protected $dates = [
        'approved_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * El formato de almacenamiento de las columnas de tipo fecha del modelo.
     *
     * @var  string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * Los "accessors" a adjuntar al modelo cuando sea convertido a array o Json.
     *
     * @var  array
     */
    protected $appends = [];

    /**
     * Casting de atributos a los tipos de datos nativos.
     *
     * @var  array
     */
    public $casts = [
        'id' => 'int',
        'reason_id' => 'int',
        'name' => 'string',
        'author' => 'string',
        'genre' => 'string',
        'stars' => 'int',
        'enabled' => 'boolean',
        'status' => 'string',
        'unlocking_word' => 'string',
        'synopsis' => 'string',
        'approved_by' => 'int',
        'approved_password' => 'string',
    ];

    /**
     * Los valores de la columna status que es de tipo enum, esto
     * para los casos en que sea utilizada una base de datos sqlite, pues sqlite
     * no soporta campos de tipo enum.
     *
     * @var  string
     */
    protected static $statusColumnEnumValues = "enum('setting_documents','waiting_confirmation','reviewing','approved')";

    /**
     * La relación con App\Models\Reason.
     */
    public function reason()
    {
        return $this->belongsTo('App\Models\Reason', 'reason_id');
    }
    /**
     * La relación con llstarscreamll\Core\Models\User.
     */
    public function approvedBy()
    {
        return $this->belongsTo('llstarscreamll\Core\Models\User', 'approved_by');
    }
}
