<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * {{ $gen->entityName() }}CreationFailedException Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $gen->entityName() }}CreationFailedException extends Exception
{
	public $httpStatusCode = Response::HTTP_CONFLICT;
    public $message = 'Failed creating new {{ $gen->entityName() }}.';
}
