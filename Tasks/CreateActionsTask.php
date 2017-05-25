<?php

namespace App\Containers\Crud\Tasks;

use Illuminate\Support\Collection;
use App\Containers\Crud\Traits\DataGenerator;
use App\Containers\Crud\Traits\FolderNamesResolver;

/**
 * CreateActionsTask Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateActionsTask
{
    use FolderNamesResolver;
    use DataGenerator;

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
     * The actions files to generate.
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
        'SelectListFrom',
    ];

    /**
     * The parsed fields from request.
     *
     * @var Illuminate\Support\Collection
     */
    public $parsedFields;

    /**
     * Create new CreateActionsTask instance.
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
     * @return bool
     */
    public function run()
    {
        $this->createEntityActionsFolder();
        
        foreach ($this->files as $file) {
            // prevent to create Restore test if table hasn't SoftDelete column
            if (str_contains($file, ['Restore']) && !$this->hasSoftDeleteColumn) {
                continue;
            }
            
            $plural = ($file == "ListAndSearch") ? true : false;
            $atStart = in_array($file, ['FormData']) ? true : false;

            $actionFile = $this->actionsFolder()."{$this->solveGroupClasses('d')}/".$this->actionFile($file, $plural, $atStart);
            $template = $this->templatesDir().'.Porto/Actions/'.$file;

            $content = view($template, [
                'gen' => $this,
                'fields' => $this->parsedFields
            ]);

            file_put_contents($actionFile, $content) === false
                ? session()->push('error', "Error creating $file action file")
                : session()->push('success', "$file action creation success");
        }

        return true;
    }

    /**
     * Create the entity actions folder.
     *
     * @return void
     */
    private function createEntityActionsFolder()
    {
        if (!file_exists($this->actionsFolder().'/'.$this->entityName()) && $this->request->get('group_main_apiato_classes', false)) {
            mkdir($this->actionsFolder().'/'.$this->entityName());
        }
    }
}
