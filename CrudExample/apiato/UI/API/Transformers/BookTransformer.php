<?php

namespace App\Containers\Library\UI\API\Transformers;

use App\Ship\Parents\Transformers\Transformer;
use App\Containers\Reason\UI\API\Transformers\ReasonTransformer;
use App\Containers\User\UI\API\Transformers\UserTransformer;
use App\Containers\Library\Models\Book;

/**
 * BookTransformer Class.
 * 
 * @author  [name] <[<email address>]>
 */
class BookTransformer extends Transformer
{
	/**
	 * @var  array
	 */
	protected $availableIncludes = [
        'reason',
        'approvedBy',
    ];

	/**
     * @var  array
     */
    protected $defaultIncludes = [];

    /**
     * @param  App\Containers\Library\Models\Book $book
     *
     * @return  array
     */
    public function transform(Book $book)
    {
    	$response = [
    		'object' => 'Book',
			'id' => $book->getHashedKey(),
            'reason_id' => $this->hashKey($book->reason_id),
			'name' => $book->name,
			'author' => $book->author,
			'genre' => $book->genre,
			'stars' => $book->stars,
			'published_year' => $book->published_year,
			'enabled' => $book->enabled,
			'status' => $book->status,
			'synopsis' => $book->synopsis,
			'approved_at' => $book->approved_at,
            'approved_at' => $book->approved_at ? $book->approved_at->toDateTimeString() : null,
            'approved_by' => $this->hashKey($book->approved_by),
			'created_at' => $book->created_at,
            'created_at' => $book->created_at ? $book->created_at->toDateTimeString() : null,
			'updated_at' => $book->updated_at,
            'updated_at' => $book->updated_at ? $book->updated_at->toDateTimeString() : null,
			'deleted_at' => $book->deleted_at,
            'deleted_at' => $book->deleted_at ? $book->deleted_at->toDateTimeString() : null,
    	];

        $response = $this->ifAdmin([
            'real_id' => $book->id,
        ], $response);

        return $response;
    }

    public function includeReason(Book $book)
    {
        return $book->reason
            ? $this->item($book->reason, new ReasonTransformer())
            : null;
    }

    public function includeApprovedBy(Book $book)
    {
        return $book->approvedBy
            ? $this->collection($book->approvedBy, new UserTransformer())
            : null;
    }
}