<?php

namespace App\Containers\Crud\Actions;

use Illuminate\Http\Request;
use App\Containers\Crud\Tasks\CopyAngularModuleTask;
use App\Containers\Crud\Tasks\CopyPortoContainerTask;

/**
* CopyDirsAction Class.
*
* @author Johan Alvarez <llstarscreamll@hotmail.com>
*/
class CopyDirsAction
{
	public function run(Request $request)
	{
		if (!empty($request->get('copy_angular_module_to'))) {
			$copyAngularModuleTask = new CopyAngularModuleTask($request);
			$copyAngularModuleTask->run($request->get('copy_angular_module_to', ''));
		}

		if (!empty($request->get('copy_porto_container_to'))) {
			$copyPortoContainerTask = new CopyPortoContainerTask($request);
			$copyPortoContainerTask->run($request->get('copy_porto_container_to', ''));
		}
	}
}
