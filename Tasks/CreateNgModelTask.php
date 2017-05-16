<?php

namespace App\Containers\Crud\Tasks;

use Illuminate\Support\Collection;
use App\Containers\Crud\Traits\DataGenerator;
use App\Containers\Crud\Traits\AngularFolderNamesResolver;

/**
 * CreateNgModelTask Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateNgModelTask
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
     * The parsed fields from request.
     *
     * @var Illuminate\Support\Collection
     */
    public $parsedFields;

    /**
     * Create new CreateNgModelTask instance.
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
        $this->generateModel('model', camel_case($this->entityName()));
        $this->generateModel('pagination', camel_case($this->entityName()).'Pagination');
    }

    public function generateModel($template, $model)
    {
        $moduleFile = $this->modelsDir()."/$model.ts";
        $template = $this->templatesDir().'.Angular2/models/'.$template;

        $content = view($template, [
            'gen' => $this,
            'fields' => $this->parsedFields
        ]);

        file_put_contents($moduleFile, $content) === false
            ? session()->push('error', "Error creating Angular Entity Model file")
            : session()->push('success', "Angular Entity Model creation success");

        return true;
    }
}
