<?php

namespace App\Containers\Crud\Tasks;

use Illuminate\Http\Request;
use App\Containers\Crud\Traits\DataGenerator;
use App\Containers\Crud\Traits\FolderNamesResolver;

/**
 * CreatePortoCriteriasTask Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreatePortoCriteriasTask
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
     * The actions files to generate.
     *
     * @var array
     */
    public $files = [
        'Advanced:entity:Search',
    ];

    /**
     * Create new CreatePortoCriteriasTask instance.
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
        $this->createEntityCriteriasFolder();
        
        foreach ($this->files as $file) {
            $plural = ($file == "") ? true : false;

            $criteriaFile = $this->criteriasFolder()."/{$this->entityName()}/".$this->criteriaFile($file, $plural);
            $template = $this->templatesDir().'.Porto/Data/Criterias/'.$file;

            $content = view($template, [
                'gen' => $this,
                'fields' => $this->parseFields($this->request)
            ]);

            file_put_contents($criteriaFile, $content) === false
                ? session()->push('error', "Error creating $file action file")
                : session()->push('success', "$file action creation success");
        }

        return true;
    }

    /**
     * Create the entity actions folder.
     *
     * @return void
     */
    private function createEntityCriteriasFolder()
    {
        if (!file_exists($this->criteriasFolder().'/'.$this->entityName())) {
            mkdir($this->criteriasFolder().'/'.$this->entityName());
        }
    }
}
