<?php

namespace App\Containers\Crud\Tasks;

use Illuminate\Http\Request;
use App\Containers\Crud\Traits\DataGenerator;
use App\Containers\Crud\Traits\FolderNamesResolver;

/**
 * CreateApiRoutesTask Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateApiRoutesTask
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
        'Create:entity:',
        'Delete:entity:',
        'FormDataFrom:entity:',
        'FormModelFrom:entity:',
        'Get:entity:',
        'ListAndSearch:entity:',
        'Restore:entity:',
        'Update:entity:',
    ];

    /**
     * Create new CreateApiRoutesTask instance.
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
            // prevent to create Restore route if table hasn't SoftDelete column
            if (str_contains($file, ['Restore']) && !$this->hasSoftDeleteColumn) {
                continue;
            }

            $plural = ($file == "ListAndSearch") ? true : false;
            $atStart = in_array($file, ['_FormModel', '_FormData',]) ? true : false;

            $routeFile = $this->apiRoutesFolder().'/'.$this->apiRouteFile($file, $plural);
            $template = $this->templatesDir().'.Porto/UI/API/Routes/'.$file;

            $content = view($template, ['gen' => $this]);

            file_put_contents($routeFile, $content) === false
                ? session()->push('error', "Error creating $file task file")
                : session()->push('success', "$file task creation success");
        }

        return true;
    }
}
