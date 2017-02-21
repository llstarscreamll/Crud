<?php

namespace llstarscreamll\Crud\Tasks;

use Illuminate\Http\Request;
use llstarscreamll\Crud\Traits\FolderNamesResolver;
use llstarscreamll\Crud\Traits\DataGenerator;

/**
 * CreateModelTask Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateModelTask
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
     * Create new CreateModelTask instance.
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
        $file = 'Model';

        $factoryFile = $this->modelsFolder()."/{$this->entityName()}.php";
        $template = $this->templatesDir().'.Porto/Models/'.$file;

        $content = view($template, [
            'gen' => $this,
            'fields' => $this->parseFields($this->request)
            ]);

        file_put_contents($factoryFile, $content) === false
            ? session()->push('error', "Error creating $file file")
            : session()->push('success', "$file creation success");

        return true;
    }
}
