<?php

namespace App\Containers\Library\Data\Repositories;

use Illuminate\Http\Request;
use App\Ship\Parents\Repositories\Repository;
use App\Ship\Criterias\Eloquent\TrashedCriteria;

/**
 * BookRepository Class.
 * 
 * @author  [name] <[<email address>]>
 */
class BookRepository extends Repository
{
	/**
	 * Container name reference for set the model.
	 *
	 * @var  string
	 */
	protected $container = 'Library';

	/**
     * @var  array
     */
    protected $fieldSearchable = [
        'reason_id' => 'like',
        'reason.name' => 'like',
        'name' => 'like',
        'author' => 'like',
        'genre' => 'like',
        'stars' => 'like',
        'published_year' => 'like',
        'enabled' => 'like',
        'status' => 'like',
        'unlocking_word' => 'like',
        'synopsis' => 'like',
        'approved_at' => 'like',
        'approved_by' => 'like',
        'approvedBy.name' => 'like',
        'approved_password' => 'like',
    ];
    
    /**
     * Push the parent and Trashed criterias.
     */
    public function boot()
    {
        parent::boot();
        $this->pushCriteria(new TrashedCriteria(app(Request::class)->get('trashed', '')));
    }

    /**
     * Restores a softdeleted row.
     * @param    int $id
     * @return  App\Containers\Library\Models\Book $book
     */
    public function restore(int $id)
    {
        $this->model->withTrashed()->find($id)->restore();
        return $this->model->find($id);
    }
}