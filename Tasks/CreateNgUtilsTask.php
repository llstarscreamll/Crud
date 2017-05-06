<?php

namespace App\Containers\Crud\Tasks;

use Illuminate\Http\Request;
use App\Containers\Crud\Traits\DataGenerator;
use App\Containers\Crud\Traits\AngularFolderNamesResolver;

/**
 * CreateNgUtilsTask Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateNgUtilsTask
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
        ':entity:-testing',
    ];

    /**
     * The parsed fields from request.
     *
     * @var Illuminate\Support\Collection
     */
    public $parsedFields;

    /**
     * Create new CreateNgUtilsTask instance.
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
        foreach ($this->files as $file) {
            $containerFile = $this->utilsDir()."/".$this->utilFile($file);
            $template = $this->templatesDir().'.Angular2.utils.'.$file;

            $content = view($template, [
                'gen' => $this,
                'request' => $this->request,
                'fields' => $this->parsedFields
            ]);

            file_put_contents($containerFile, $content) === false
                ? session()->push('error', "Error creating $file util file")
                : session()->push('success', "$file util creation success");
        }

        return true;
    }
}
