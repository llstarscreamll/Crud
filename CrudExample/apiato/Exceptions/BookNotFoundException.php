<?php

namespace App\Containers\Library\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * BookNotFoundException Class.
 * 
 * @author  [name] <[<email address>]>
 */
class BookNotFoundException extends Exception
{
	public $httpStatusCode = Response::HTTP_BAD_REQUEST;
    public $message = 'Could not find the Book in our database.';
}
