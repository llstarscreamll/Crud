<?php

namespace llstarscreamll\Crud\Tasks;

use Illuminate\Http\Request;
use llstarscreamll\Crud\Traits\DataGenerator;
use llstarscreamll\Crud\Traits\FolderNamesResolver;

/**
 * CreateExceptionsTask Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateExceptionsTask
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
     * The exception files to generate.
     *
     * @var array
     */
    public $files = [
        'CreationFailedException',
        'NotFoundException',
    ];

    /**
     * Create new CreateExceptionsTask instance.
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
        foreach ($this->files as $file) {
            $exceptionFile = $this->exceptionsFolder()."/{$this->entityName()}{$file}.php";
            $template = $this->templatesDir().'.Porto/Exceptions/'.$file;

            $content = view($template, ['gen' => $this]);

            file_put_contents($exceptionFile, $content) === false
                ? session()->push('error', "Error creating $file task file")
                : session()->push('success', "$file task creation success");
        }

        return true;
    }
}
