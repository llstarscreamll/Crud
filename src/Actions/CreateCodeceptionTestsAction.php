<?php

namespace llstarscreamll\Crud\Actions;

use Illuminate\Http\Request;
use llstarscreamll\Crud\Traits\FolderNamesResolver;

/**
 * CreateCodeceptionTestsAction Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateCodeceptionTestsAction
{
    use FolderNamesResolver;

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
     * The tests files to generate.
     *
     * @var array
     */
    public $files = [
        'List',
        'Create',
        'Update',
        'Delete',
        'Restore',
    ];

    /**
     * Create new CreateCodeceptionTestsAction instance.
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
     * @param string $container Contaner name
     *
     * @return bool
     */
    public function run()
    {
        $this->bootstrapCodeception();

        $this->createCodeceptApiSuite();

        $this->configureCodeceptSuite('api');
        $this->configureCodeceptSuite('functional');

        // builds Codeception suites
        exec("cd {$this->containerFolder()} && codecept build");

        $this->generateApiTests();

        return true;
    }

    /**
     * Bootstraps Codeception on container.
     */
    public function bootstrapCodeception()
    {
        if (!file_exists($this->containerFolder().'/codeception.yml')) {
            exec("cd {$this->containerFolder()} && codecept bootstrap --namespace=".$this->containerName());
        } else {
            session()->push('warning', 'Codeception tests already bootstraped!!');
        }
    }

    /**
     * Create Codeception suite for API tests.
     */
    public function createCodeceptApiSuite()
    {
        if (!file_exists($this->apiTestsFolder())) {
            exec("cd {$this->containerFolder()} && codecept generate:suite api");
        } else {
            session()->push('warning', 'Codeception tests already bootstraped!!');
        }
    }

    /**
     * Adds Laravel module for Codeception suite.
     *
     * @param string $suite The codeception suite name
     */
    private function configureCodeceptSuite(string $suite)
    {
        $suiteContent = file_get_contents($this->containerFolder()."/tests/$suite.suite.yml");

        if (strpos($suiteContent, $this->getLaravelCodeceptSuitModule()) === false) {
            $suiteContent .= $this->getLaravelCodeceptSuitModule();
            file_put_contents($this->containerFolder()."/tests/$suite.suite.yml", $suiteContent);
        } else {
            session()->push('warning', "Codeception setup for $suite.suite.yml already set!!");
        }
    }

    /**
     * Returns the modules to enable on Codeception suites.
     *
     * @return string
     */
    private function getLaravelCodeceptSuitModule()
    {
        return "\n        - Asserts\n".
            "        - Laravel5:\n".
            "            environment_file: .env.testing\n".
            "            root: ../../../\n".
            '            run_database_migrations: true';
    }

    private function generateApiTests()
    {
        $this->createEntityApiTestsFolder();

        foreach ($this->files as $file) {
            $plural = ($file == 'List') ? true : false;

            $testFile = $this->apiTestsFolder()."/{$this->entityName()}/".$this->apiTestFile($file, $plural);
            $template = $this->templatesDir().'.Porto/tests/api/'.$file;

            $content = view($template, ['gen' => $this]);

            file_put_contents($testFile, $content) === false
                ? session()->push('error', "Error creating $file api test file")
                : session()->push('success', "$file api test creation success");
        }
    }

    /**
     * Creates the API entity tests folder.
     */
    private function createEntityApiTestsFolder()
    {
        if (!file_exists($this->apiTestsFolder().'/'.$this->entityName())) {
            mkdir($this->apiTestsFolder().'/'.$this->entityName());
        }
    }
}
