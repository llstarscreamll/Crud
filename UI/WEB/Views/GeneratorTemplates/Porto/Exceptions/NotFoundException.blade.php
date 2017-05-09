<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * {{ $gen->entityName() }}NotFoundException Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $gen->entityName() }}NotFoundException extends Exception
{
	public $httpStatusCode = Response::HTTP_BAD_REQUEST;
    public $message = 'Could not find the {{ $gen->entityName() }} in our database.';
}
