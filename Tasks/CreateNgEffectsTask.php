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
     * Create new CreateNgEffectsTask instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->container = studly_case($request->get('is_part_of_package'));
        $this->tableName = $this->request->get('table_name');

        $this->effectFile = camel_case($this->entityName());
    }

    /**
     * @return bool
     */
    public function run()
    {
        $this->generateIndexFile();

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

    private function generateIndexFile()
    {
        $className = $this->entityName().'Effects';
        $indexFilePath = $this->effectsDir().'/index.ts';
        $template = $this->templatesDir().'.Angular2/effects/index';

        if (file_exists($indexFilePath)) {
            $indexFileContents = file_get_contents($indexFilePath);
            
            if (strpos($indexFileContents, $className)) {
                session()->push('warning', $className.' already added on index effects file');
            } else {
                $replace = $this->prepareFileContents();

                $content = str_replace(
                    $this->indexStrToreplace,
                    $replace,
                    $indexFileContents
                );

                file_put_contents($indexFilePath, $content) === false
                ? session()->push('error', "Effects index file setup error")
                : session()->push('success', "Effects index file setup success");
            }
            
            return;
        }

        $content = view($template, [
            'gen' => $this,
            'fields' => $this->parseFields($this->request)
        ]);

        file_put_contents($indexFilePath, $content) === false
            ? session()->push('error', "Error creating index Effects file")
            : session()->push('success', "Angular index Effects creation success");
    }

    public function prepareFileContents()
    {
        $className = $this->entityName().'Effects';
        $file = $this->effectFile.'.effectss';
        $classImport = "import { $className } from '$file'";
        $classUsage = $this->indexStrToreplace."\n  $className,";

        return $classImport."\n".$classUsage;
    }
}
