<?php

namespace App\Containers\Crud\Tasks;

use Illuminate\Support\Collection;
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
     * @var string
     */
    private $indexStrToreplace = "\nexport const COMPONENTS = [";

    /**
     * The modules files to generate.
     *
     * @var array
     */
    public $files = [
        'abstract',
        'form',
        'form-html',
        'form-spec',
        'table',
        'table-spec',
        'table-html',
        'search-basic',
        'search-basic-spec',
        'search-basic-html',
        'search-advanced',
        'search-advanced-spec',
        'search-advanced-html',
        'index',
    ];

    /**
     * The parsed fields from request.
     *
     * @var Illuminate\Support\Collection
     */
    public $parsedFields;

    /**
     * Create new CreateNgComponentsTask instance.
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
        // generate the main index file for components
        $indexFilePath = $this->componentsDir().'/../index.ts';
        $template = $this->templatesDir().'.Angular2/components/main-index';
        $className = $this->entityName().'Components';
        $fileName = './'.$this->slugEntityName().'';

        $this->setupIndexFile($indexFilePath, $template, $className, $fileName);

        foreach ($this->files as $file) {
            $plural = strpos($file, "table") !== false ? true : false;

            $componentFile = $this->componentsDir()."/".$this->componentFile($file, $plural);
            $template = $this->templatesDir().'.Angular2.components.'.$file;

            $content = view($template, [
                'crud' => $this,
                'fields' => $this->parsedFields
            ]);

            file_put_contents($componentFile, $content) === false
                ? session()->push('error', "Error creating $file component file")
                : session()->push('success', "$file component creation success");
        }

        return true;
    }
}
