<?php

namespace App\Containers\Crud\Tasks;

use Illuminate\Support\Collection;
use App\Containers\Crud\Traits\FolderNamesResolver;
use App\Containers\Crud\Traits\DataGenerator;

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
        'Create',
        'Delete',
        'Get',
        'ListAndSearch',
        'SelectListFrom',
        'Restore',
        'Update',
    ];

    /**
     * The parsed fields from request.
     *
     * @var Illuminate\Support\Collection
     */
    public $parsedFields;

    /**
     * Create new CreateTasksFilesAction instance.
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
        $this->createEntityApiRequestsFolder();

        foreach ($this->files as $file) {
            // prevent to create Restore test if table hasn't SoftDelete column
            //if($file === "Restore") dd(str_contains($file, ['Restore']), !$this->hasSoftDeleteColumn, $file);
            if (str_contains($file, ['Restore']) && !$this->hasSoftDeleteColumn) {
                continue;
            }
            $plural = ($file == "ListAndSearch") ? true : false;

            $actionFile = $this->apiRequestsFolder()."/{$this->entityName()}/".$this->apiRequestFile($file, $plural);
            $template = $this->templatesDir().'.Porto/UI/API/Requests/'.$file;

            $content = view($template, [
                'gen' => $this,
                'fields' => $this->parsedFields
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
