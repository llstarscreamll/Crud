<?php

namespace App\Containers\Crud\Tasks;

use Illuminate\Support\Collection;
use App\Containers\Crud\Traits\DataGenerator;
use App\Containers\Crud\Traits\AngularFolderNamesResolver;

/**
 * CreateNgConfigsTask Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateNgConfigsTask
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
        'form-model',
    ];

    /**
     * The parsed fields from request.
     *
     * @var Illuminate\Support\Collection
     */
    public $parsedFields;

    /**
     * Create new CreateNgConfigsTask instance.
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
        $this->createConfigDir();

        foreach ($this->files as $file) {
            $configFile = $this->configDir()."{$this->slugEntityName()}-{$file}.ts";
            $template = $this->templatesDir().".Angular2.config.{$file}";

            $content = view($template, [
                'crud' => $this,
                'fields' => $this->parsedFields
            ]);

            file_put_contents($configFile, $content) === false
                ? session()->push('error', "Error creating $file config file")
                : session()->push('success', "$file config creation success");
        }

        return true;
    }

    public function createConfigDir()
    {
        // create config folder
        if (!file_exists($this->configDir())) {
            mkdir($this->configDir());
        }
    }
}
