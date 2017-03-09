<?php

namespace App\Containers\Crud\Tasks;

use Illuminate\Http\Request;
use App\Containers\Crud\Traits\DataGenerator;
use App\Containers\Crud\Traits\AngularFolderNamesResolver;

/**
 * CreateNgComponentsTask Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateNgComponentsTask
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
        'table',
        'table-css',
        'table-html',
        'form',
        'form-css',
        'form-html',
    ];

    /**
     * Create new CreateNgComponentsTask instance.
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
            $plural = strpos($file, "table") !== false ? true : false;

            $componentFile = $this->componentsDir()."/".$this->componentFile($file, $plural);
            $template = $this->templatesDir().'.Angular2.components.'.$file;

            $content = view($template, [
                'gen' => $this,
                'fields' => $this->parseFields($this->request)
            ]);

            file_put_contents($componentFile, $content) === false
                ? session()->push('error', "Error creating $file component file")
                : session()->push('success', "$file component creation success");
        }

        return true;
    }
}
