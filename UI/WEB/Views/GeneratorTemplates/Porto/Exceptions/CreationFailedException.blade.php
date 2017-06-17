<?= "<?php\n" ?>

namespace App\Containers\{{ $crud->containerName() }}\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * {{ $crud->entityName() }}CreationFailedException Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $crud->entityName() }}CreationFailedException extends Exception
{
	public $httpStatusCode = Response::HTTP_CONFLICT;
    public $message = 'Failed creating new {{ $crud->entityName() }}.';
}
