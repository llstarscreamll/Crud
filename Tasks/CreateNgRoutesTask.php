<?php

namespace App\Containers\Crud\Tasks;

use Illuminate\Http\Request;
use App\Containers\Crud\Traits\DataGenerator;
use App\Containers\Crud\Traits\AngularFolderNamesResolver;

/**
 * CreateNgRoutesTask Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateNgRoutesTask
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
    private $indexStrToreplace = "\nexport const ROUTES = [";

    /**
     * @var string
     */
    private $indexClassTemplate = "...:class";

    /**
     * Create new CreateNgRoutesTask instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->container = studly_case($request->get('is_part_of_package'));
        $this->tableName = $this->request->get('table_name');

        $this->routesFile = $this->slugEntityName();
    }

    /**
     * @return bool
     */
    public function run()
    {
        $indexFilePath = $this->routesDir().'/index.ts';
        $template = $this->templatesDir().'.Angular2.routes.main-index';
        $className = $this->entityName().'Routes';
        $fileName = './'.$this->routesFile.'.routes';

        $this->setupIndexFile($indexFilePath, $template, $className, $fileName);

        $this->routesFile = $this->routesDir()."/$this->routesFile.routes.ts";
        $template = $this->templatesDir().'.Angular2.routes.routes';

        $content = view($template, [
            'gen' => $this,
            'fields' => $this->parseFields($this->request)
        ]);

        file_put_contents($this->routesFile, $content) === false
            ? session()->push('error', "Error creating Angular routes file")
            : session()->push('success', "Angular routes creation success");

        return true;
    }
}
