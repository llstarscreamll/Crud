<?php

namespace llstarscreamll\Crud\Tasks;

use Illuminate\Http\Request;
use llstarscreamll\Crud\Traits\DataGenerator;
use llstarscreamll\Crud\Traits\FolderNamesResolver;

/**
 * PortoFoldersGeneration Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateTasksTask
{
    use FolderNamesResolver, DataGenerator;

    /**
     * Container name to generate.
     *
     * @var string
     */
    public $container;

    /**
     * Container entity to generate (database table name).
     *
     * @var string
     */
    public $tableName;

    /**
     * The tasks files to generate.
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
     * Create new CreateTasksTask instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->container = studly_case($request->get('is_part_of_package'));
        $this->tableName = $this->request->get('table_name');
    }

    /**
     * @param string $container Contaner name
     *
     * @return bool
     */
    public function run()
    {
        $this->createEntityTasksFolder();

        foreach ($this->files as $file) {
            $plural = ($file == "ListAndSearch") ? true : false;

            $taskFile = $this->tasksFolder()."/{$this->entityName()}/".$this->taskFile($file, $plural);
            $template = $this->templatesDir().'.Porto.Tasks.'.$file;

            $content = view($template, [
                'gen' => $this,
                'fields' => $this->parseFields($this->request)
            ]);

            file_put_contents($taskFile, $content) === false
                ? session()->push('error', "Error creating $file task file")
                : session()->push('success', "$file task creation success");
        }

        return true;
    }

    /**
     * Create the entity tasks folder.
     *
     * @return void
     */
    private function createEntityTasksFolder()
    {
        if (!file_exists($this->tasksFolder().'/'.$this->entityName())) {
            mkdir($this->tasksFolder().'/'.$this->entityName());
        }
    }
}
