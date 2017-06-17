<?= "<?php\n" ?>

namespace App\Containers\{{ $crud->containerName() }}\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * {{ $crud->entityName() }}NotFoundException Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $crud->entityName() }}NotFoundException extends Exception
{
	public $httpStatusCode = Response::HTTP_BAD_REQUEST;
    public $message = 'Could not find the {{ $crud->entityName() }} in our database.';
}
