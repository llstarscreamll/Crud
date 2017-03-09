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
     * Create new CreateNgEffectsTask instance.
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
        $effectFile = camel_case($this->entityName());
        $effectFile = $this->effectsDir()."/$effectFile.effects.ts";
        $template = $this->templatesDir().'.Angular2/effects/effects';

        $content = view($template, [
            'gen' => $this,
            'fields' => $this->parseFields($this->request)
        ]);

        file_put_contents($effectFile, $content) === false
            ? session()->push('error', "Error creating Angular Effects file")
            : session()->push('success', "Angular Effects creation success");

        return true;
    }
}
