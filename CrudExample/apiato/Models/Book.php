<?php

namespace App\Containers\Library\Models;

use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Book Class.
 * 
 * @author  [name] <[<email address>]>
 */
class Book extends Model
{
	use SoftDeletes;

	/**
     * Database connection name.
     *
     * @var  string
     */
    // protected $connection = 'connection-name';

    /**
     * Database table name.
     *
     * @var  string
     */
    protected $table = 'books';

    /**
     * Primary key.
     *
     * @var  string
     */
    protected $primaryKey = 'id';

    /**
     * Mass assignable attributes.
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
     * Hidden fields.
     *
     * @var  array
     */
    protected $hidden = [
        'unlocking_word',
        'approved_password',
    ];

    /**
     * Should Laravel handle timestamps?
     *
     * @var  bool
     */
    public $timestamps = true;

    /**
     * Attributes casted to Carbon dates.
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
     * Dates storage format.
     *
     * @var  string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * The attributes that should be casted to native types.
     *
     * @var  array
     */
    protected $casts = [
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
     * Relation with App\Containers\Reason\Models\Reason.

     */
    public function reason()
    {
        return $this->belongsTo('App\Containers\Reason\Models\Reason', 'reason_id');
    }
}
