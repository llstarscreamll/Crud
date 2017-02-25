<?php

namespace llstarscreamll\Crud\Tasks;

use Illuminate\Http\Request;
use llstarscreamll\Crud\Traits\DataGenerator;
use llstarscreamll\Crud\Traits\AngularFolderNamesResolver;

/**
 * CreateNgServiceTask Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateNgServiceTask
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
     * Create new CreateNgServiceTask instance.
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
        $serviceFile = camel_case($this->entityName());
        $serviceFile = $this->servicesDir()."/$serviceFile.service.ts";
        $template = $this->templatesDir().'.Angular2/services/service';

        $content = view($template, [
            'gen' => $this,
            'fields' => $this->parseFields($this->request)
        ]);

        file_put_contents($serviceFile, $content) === false
            ? session()->push('error', "Error creating Angular Service file")
            : session()->push('success', "Angular Service creation success");

        return true;
    }
}
