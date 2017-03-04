<?php

namespace llstarscreamll\Crud\Tasks;

use Illuminate\Http\Request;
use llstarscreamll\Crud\Traits\FolderNamesResolver;
use llstarscreamll\Crud\Traits\DataGenerator;

/**
 * CreateFormModelConfigTask Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateFormModelConfigTask
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
     * Create new CreateFormModelConfigTask instance.
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
        $file = $this->slugEntityName();

        $factoryFile = $this->createModelFormsConfigDir()."/{$file}.php";
        $template = $this->templatesDir().'.Porto.Configs.form-model';

        $content = view($template, [
            'gen' => $this,
            'fields' => $this->parseFields($this->request)
            ]);

        file_put_contents($factoryFile, $content) === false
            ? session()->push('error', "Error creating form model config file")
            : session()->push('success', "Form model config creation success");

        return true;
    }

    private function createModelFormsConfigDir()
    {
        $dir = $this->configsFolder().'/form-models';
        if (!file_exists($dir)) {
            mkdir($dir);
        }

        return $dir;
    }
}
