<?php

namespace App\Containers\Crud\Tasks;

use Illuminate\Support\Collection;
use App\Containers\Crud\Traits\DataGenerator;
use App\Containers\Crud\Traits\FolderNamesResolver;

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
        'Create',
        'Get',
        'Update',
        'Delete',
        'Restore',
        'ListAndSearch',
    ];

    /**
     * The parsed fields from request.
     *
     * @var Illuminate\Support\Collection
     */
    public $parsedFields;

    /**
     * Create new CreateTasksTask instance.
     *
     * @param Collection $request
     */
    public function __construct(Collection $request)
    {
        $this->request = $request;
        $this->container = studly_case($request->get('is_part_of_package'));
        $this->tableName = $this->request->get('table_name');
        $this->parsedFields = $this->parseFields($this->request);
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
            // prevent to create Restore test if table hasn't SoftDelete column
            if (str_contains($file, ['Restore']) && !$this->hasSoftDeleteColumn) {
                continue;
            }
            
            $plural = ($file == "ListAndSearch") ? true : false;

            $taskFile = $this->tasksFolder()."{$this->solveGroupClasses('d')}/".$this->taskFile($file, $plural);
            $template = $this->templatesDir().'.Porto.Tasks.'.$file;

            $content = view($template, [
                'crud' => $this,
                'fields' => $this->parsedFields
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
        if (!file_exists($this->tasksFolder().'/'.$this->entityName()) && $this->request->get('group_main_apiato_classes', false)) {
            mkdir($this->tasksFolder().'/'.$this->entityName());
        }
    }
}
