<?php

namespace llstarscreamll\Crud\Actions;

use Illuminate\Http\Request;
use llstarscreamll\Crud\Traits\DataGenerator;
use llstarscreamll\Crud\Traits\FolderNamesResolver;

/**
 * CreateApiRoutesFilesAction Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateApiRoutesFilesAction
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
     * The routes files to generate.
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
     * Create new CreateModelAction instance.
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
     * @return bool
     */
    public function run()
    {
        foreach ($this->files as $file) {
            $plural = ($file == "List") ? true : false;

            $actionFile = $this->apiRoutesFolder().'/'.$this->apiRouteFile($file, $plural);
            $template = $this->templatesDir().'.Porto/UI/API/Routes/'.$file;

            $content = view($template, ['gen' => $this]);

            file_put_contents($actionFile, $content) === false
                ? session()->push('error', "Error creating $file task file")
                : session()->push('success', "$file task creation success");
        }

        return true;
    }
}
