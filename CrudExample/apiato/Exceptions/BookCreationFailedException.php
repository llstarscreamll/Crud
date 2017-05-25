<?php

namespace App\Containers\Library\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * BookCreationFailedException Class.
 * 
 * @author  [name] <[<email address>]>
 */
class BookCreationFailedException extends Exception
{
	public $httpStatusCode = Response::HTTP_CONFLICT;
    public $message = 'Failed creating new Book.';
}
