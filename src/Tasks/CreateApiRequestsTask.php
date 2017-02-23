<?php

namespace llstarscreamll\Crud\Tasks;

use Illuminate\Http\Request;
use llstarscreamll\Crud\Traits\FolderNamesResolver;
use llstarscreamll\Crud\Traits\DataGenerator;

/**
 * CreateApiRequestsTask Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateApiRequestsTask
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
     * The routes files to generate.
     *
     * @var array
     */
    public $files = [
        'ListAndSearch',
        'Create',
        'Get',
        'Update',
        'Delete',
        'Restore',
    ];

    /**
     * Create new CreateTasksFilesAction instance.
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
        $this->createEntityApiRequestsFolder();

        foreach ($this->files as $file) {
            $plural = ($file == "ListAndSearch") ? true : false;

            $actionFile = $this->apiRequestsFolder()."/{$this->entityName()}/".$this->apiRequestFile($file, $plural);
            $template = $this->templatesDir().'.Porto/UI/API/Requests/'.$file;

            $content = view($template, [
                'gen' => $this,
                'fields' => $this->parseFields($this->request)
            ]);

            file_put_contents($actionFile, $content) === false
                ? session()->push('error', "Error creating $file api request file")
                : session()->push('success', "$file api request creation success");
        }

        return true;
    }

    /**
     * Create the entity api requests folder.
     *
     * @return void
     */
    private function createEntityApiRequestsFolder()
    {
        if (!file_exists($this->apiRequestsFolder().'/'.$this->entityName())) {
            mkdir($this->apiRequestsFolder().'/'.$this->entityName());
        }
    }
}
