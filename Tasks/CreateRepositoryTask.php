<?php

namespace App\Containers\Crud\Tasks;

use Illuminate\Support\Collection;
use App\Containers\Crud\Traits\FolderNamesResolver;
use App\Containers\Crud\Traits\DataGenerator;

/**
 * CreateRepositoryTask Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateRepositoryTask
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
     * Create new CreateRepositoryTask instance.
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
        $file = 'Repository';

        $repoFile = $this->repositoriesFolder()."/{$this->entityName()}{$file}.php";
        $template = $this->templatesDir().'.Porto/Data/Repositories/'.$file;

        $content = view($template, [
            'gen' => $this,
            'fields' => $this->parsedFields
            ]);

        file_put_contents($repoFile, $content) === false
            ? session()->push('error', "Error creating $file file")
            : session()->push('success', "$file creation success");

        return true;
    }
}
