<?php

namespace llstarscreamll\Crud\Actions;

use Illuminate\Http\Request;
use llstarscreamll\Crud\Traits\FolderNamesResolver;
use llstarscreamll\Crud\Traits\DataGenerator;

/**
 * CreateApiControllerAction Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateApiControllerAction
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
     * Create new CreateApiControllerAction instance.
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
        $file = 'Controller';

        $factoryFile = $this->apiControllersFolder()."/Controller.php";
        $template = $this->templatesDir().'.Porto/UI/API/Controllers/'.$file;

        $content = view($template, [
            'gen' => $this,
            'fields' => $this->parseFields($this->request)
            ]);

        file_put_contents($factoryFile, $content) === false
            ? session()->push('error', "Error creating api $file file")
            : session()->push('success', "Api $file creation success");

        return true;
    }
}
