<?php

namespace App\Containers\Crud\Actions;

use App\Containers\Crud\Traits\FolderNamesResolver;

/**
* LoadOptionsAction Class.
*
* @author Johan Alvarez <llstarscreamll@hotmail.com>
*/
class LoadOptionsAction
{
    use FolderNamesResolver;

	public function run(string $fileName)
	{
        $filePath = $this->optionsOutputDir().$fileName.'.php';

        if (file_exists($filePath)) {
            return require $filePath;
        }

        return [];
	}
}
