<?php

namespace llstarscreamll\Crud\Tasks;

use Illuminate\Http\Request;
use llstarscreamll\Crud\Traits\DataGenerator;
use llstarscreamll\Crud\Traits\AngularFolderNamesResolver;

/**
 * CreateNgModulesTask Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateNgModulesTask
{
    use DataGenerator, AngularFolderNamesResolver;

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
     * The modules files to generate.
     *
     * @var array
     */
    public $files = [
        'routing',
        'module',
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
            $moduleFile = $this->moduleDir()."/".$this->moduleFile($file);
            $template = $this->templatesDir().'.Angular2/'.$file;

            $content = view($template, [
                'gen' => $this,
                'fields' => $this->parseFields($this->request)
            ]);

            file_put_contents($moduleFile, $content) === false
                ? session()->push('error', "Error creating $file action file")
                : session()->push('success', "$file action creation success");
        }

        return true;
    }
}
