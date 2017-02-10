<?php

namespace llstarscreamll\Crud\Actions;

use llstarscreamll\Crud\Traits\FolderNamesResolver;

/**
 * PortoFoldersGeneration Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateTasksFilesAction
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
        'List',
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
            $plural = ($file == "List") ? true : false;

            $actionFile = $this->tasksFolder().'/'.$this->taskFile($file, $plural);
            $template = $this->templatesDir().'.Porto/Tasks/'.$file;

            $content = view($template, ['gen' => $this]);

            file_put_contents($actionFile, $content) === false
                ? session()->push('error', "Error creating $file task file")
                : session()->push('success', "$file task creation success");
        }

        return true;
    }
}
