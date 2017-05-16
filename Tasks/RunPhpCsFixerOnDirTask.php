<?php

namespace App\Containers\Crud\Tasks;

use Illuminate\Support\Collection;
use App\Containers\Crud\Traits\FolderNamesResolver;
use App\Containers\Crud\Traits\DataGenerator;

/**
 * RunPhpCsFixerOnDirTask Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class RunPhpCsFixerOnDirTask
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
     * Create new RunPhpCsFixerOnDirTask instance.
     *
     * @param Collection $request
     */
    public function __construct(Collection $request)
    {
        $this->request = $request;
        $this->container = studly_case($request->get('is_part_of_package'));
        $this->tableName = $this->request->get('table_name');
    }

    /**
     * @param string $container Contaner name
     *
     * @return bool
     */
    public function run()
    {
        exec("cd {$this->containerFolder()} && phpcbf ./ --standard=PEAR,PSR1,PSR2")
            ? session()->push('error', "Error executing php-cs-fixer")
            : session()->push('success', "php-cs-fixer execution success");

        return true;
    }
}
