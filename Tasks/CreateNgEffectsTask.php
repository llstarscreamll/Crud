<?php

namespace App\Containers\Crud\Tasks;

use Illuminate\Http\Request;
use App\Containers\Crud\Traits\DataGenerator;
use App\Containers\Crud\Traits\AngularFolderNamesResolver;

/**
 * CreateNgEffectsTask Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateNgEffectsTask
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
    private $indexStrToreplace = "\nexport const EFFECTS = [";

    /**
     * @var string
     */
    private $indexClassTemplate = "EffectsModule.run(:class)";

    /**
     * Create new CreateNgEffectsTask instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->container = studly_case($request->get('is_part_of_package'));
        $this->tableName = $this->request->get('table_name');

        $this->effectFile = $this->slugEntityName();
    }

    /**
     * @return bool
     */
    public function run()
    {
        $indexFilePath = $this->effectsDir().'/index.ts';
        $template = $this->templatesDir().'.Angular2/effects/main-index';
        $className = $this->entityName().'Effects';
        $fileName = './'.$this->effectFile.'.effects';

        $this->setupIndexFile($indexFilePath, $template, $className, $fileName);

        $this->effectFile = $this->effectsDir()."/$this->effectFile.effects.ts";
        $template = $this->templatesDir().'.Angular2/effects/effects';

        $content = view($template, [
            'gen' => $this,
            'fields' => $this->parseFields($this->request)
        ]);

        file_put_contents($this->effectFile, $content) === false
            ? session()->push('error', "Error creating Angular Effects file")
            : session()->push('success', "Angular Effects creation success");

        return true;
    }
}
