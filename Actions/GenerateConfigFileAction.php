<?php

namespace App\Containers\Crud\Actions;

/**
* GenerateConfigFileAction Class.
*
* @author Johan Alvarez <llstarscreamll@hotmail.com>
*/
class GenerateConfigFileAction
{
	public function run(array $options)
	{
		$configsDir = config('crudconfig.config_files_folder');
		$templatesDir = config('crudconfig.templates');

		// create output folder
        if (!file_exists($configsDir)) {
            // entonces la creo
            mkdir($configsDir);
        }

        // the file names is based on the database table name
        $configFile = $configsDir.'/'.$options['table_name'].'.php';

        $content = view(
            $templatesDir.'.options',
            [
            'request' => $options,
            ]
        );

        return file_put_contents($configFile, $content);
	}
}
