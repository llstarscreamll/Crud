<?php

namespace App\Containers\Crud\Tasks;

use Illuminate\Http\Request;
use App\Containers\Crud\Traits\FolderNamesResolver;
use App\Containers\Crud\Traits\DataGenerator;

/**
 * CreateTransformerTask Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateTransformerTask
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
     * The parsed fields from request.
     *
     * @var Illuminate\Support\Collection
     */
    public $parsedFields;

    /**
     * Create new CreateTransformerTask instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
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
        $file = 'Transformer';

        $factoryFile = $this->apiTransformersFolder()."/{$this->entityName()}{$file}.php";
        $template = $this->templatesDir().'.Porto/UI/API/Transformers/'.$file;

        $content = view($template, [
            'gen' => $this,
            'fields' => $this->parsedFields
            ]);

        file_put_contents($factoryFile, $content) === false
            ? session()->push('error', "Error creating $file file")
            : session()->push('success', "$file creation success");

        return true;
    }
}
