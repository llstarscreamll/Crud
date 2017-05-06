<?php

namespace App\Containers\Crud\Tasks;

use Illuminate\Http\Request;
use App\Containers\Crud\Traits\DataGenerator;
use App\Containers\Crud\Traits\AngularFolderNamesResolver;

/**
 * CreateNgReducerTask Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateNgReducerTask
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
     * Create new CreateNgReducerTask instance.
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
        $reducerFile = $this->slugEntityName();
        $reducerFile = $this->reducersDir()."/$reducerFile.reducer.ts";
        $template = $this->templatesDir().'.Angular2/reducers/reducer';

        $content = view($template, [
            'gen' => $this,
            'fields' => $this->parsedFields
        ]);

        file_put_contents($reducerFile, $content) === false
            ? session()->push('error', "Error creating Angular Reducer file")
            : session()->push('success', "Angular Reducer creation success");

        return true;
    }
}
