<?php

namespace llstarscreamll\Crud\Actions;

use llstarscreamll\Crud\Traits\FolderNamesResolver;

/**
 * CreateApiRequestsFilesAction Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateApiRequestsFilesAction
{
    use FolderNamesResolver;

    /**
     * Container name to generate.
     *
     * @var string
     */
    public $container = '';

    /**
     * The routes files to generate.
     *
     * @var array
     */
    public $files = [
        'ListAll',
        'Create',
        'Update',
        'Delete',
        'Restore',
    ];

    /**
     * @param string $container Contaner name
     *
     * @return bool
     */
    public function run(string $container)
    {
        $this->container = studly_case($container);

        foreach ($this->files as $file) {
            $plural = ($file == "ListAll") ? true : false;

            $actionFile = $this->apiRequestsFolder().'/'.$this->apiRequestFile($file, $plural);
            $template = $this->templatesDir().'.Porto/UI/API/Requests/'.$file;

            $content = view($template, ['gen' => $this]);

            file_put_contents($actionFile, $content) === false
                ? session()->push('error', "Error creating $file request file")
                : session()->push('success', "$file request creation success");
        }

        return true;
    }
}
