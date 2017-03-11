<?php

namespace App\Containers\Crud\Actions;

use App\Containers\Crud\Traits\FolderNamesResolver;

/**
* GenerateConfigFileAction Class.
*
* @author Johan Alvarez <llstarscreamll@hotmail.com>
*/
class GenerateConfigFileAction
{
    use FolderNamesResolver;

	public function run(array $options)
	{
        $this->createOutpuFolders();

		$templatesDir = config('crudconfig.templates');

        // the file names is based on the database table name
        $configFile = $this->optionsOutputDir().$options['table_name'].'.php';

        $content = view(
            $templatesDir.'.options',
            [
            'request' => $options,
            ]
        );

        return file_put_contents($configFile, $content);
	}

    /**
     * Creates the output folders where the generated code and options file will
     * be stored.
     */
    private function createOutpuFolders()
    {
        // create output folder
        if (!file_exists($this->outputDir())) {
            // entonces la creo
            mkdir($this->outputDir());
        }

        // create options output folder
        if (!file_exists($this->codeOutputDir())) {
            // entonces la creo
            mkdir($this->codeOutputDir());
        }

        // create code output folder
        if (!file_exists($this->optionsOutputDir())) {
            // entonces la creo
            mkdir($this->optionsOutputDir());
        }
    }
}
