<?php

namespace llstarscreamll\Crud\Actions;

use llstarscreamll\Crud\Traits\FolderNamesResolver;

/**
 * PortoFoldersGeneration Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateActionsFilesAction
{
    use FolderNamesResolver;

    /**
     * Container name to generate.
     *
     * @var string
     */
    public $container = '';

    /**
     * The actions files to generate.
     *
     * @var array
     */
    public $files = [
        'ListAndSearch',
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
            $plural = ($file == "ListAndSearch") ? true : false;

            $actionFile = $this->actionsFolder().'/'.$this->actionFile($file, $plural);
            $template = $this->templatesDir().'.Porto/Actions/'.$file;

            $content = view($template, ['gen' => $this]);

            file_put_contents($actionFile, $content) === false
                ? session()->push('error', "Error creating $file action file")
                : session()->push('success', "$file action creation success");
        }

        return true;
    }
}
