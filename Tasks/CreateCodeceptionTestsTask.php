<?php

namespace App\Containers\Crud\Tasks;

use Illuminate\Http\Request;
use App\Containers\Crud\Traits\FolderNamesResolver;
use App\Containers\Crud\Traits\DataGenerator;

/**
 * CreateCodeceptionTestsTask Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateCodeceptionTestsTask
{
    use FolderNamesResolver, DataGenerator;

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
        'Create',
        'Get',
        'Update',
        'Delete',
        'Restore',
        'ListAndSearch',
        'FormModel',
        'FormData',
    ];

    /**
     * Codeception Executable path.
     *
     * @var string
     */
    private $codecept = "/home/vagrant/.composer/vendor/bin/codecept";

    /**
     * The parsed fields from request.
     *
     * @var Illuminate\Support\Collection
     */
    public $parsedFields;

    /**
     * Create new CreateCodeceptionTestsTask instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->container = studly_case($request->get('is_part_of_package'));
        $this->tableName = $this->request->get('table_name');
        $this->parsedFields = $this->parseFields($this->request);
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

        $this->configureCodeceptSuite('api', $this->getApiSuiteModules());
        $this->configureCodeceptSuite('functional', $this->getFunctionalSuiteModules());
        $this->copyRootBoostrapFile();
        $this->generateEntityHelper();

        // builds Codeception suites
        exec("cd {$this->containerFolder()} && {$this->codecept} build");

        $this->generateApiTests();

        return true;
    }

    /**
     * Bootstraps Codeception on container.
     */
    public function bootstrapCodeception()
    {
        if (!file_exists($this->containerFolder().'/codeception.yml')) {
            exec("cd {$this->containerFolder()} && {$this->codecept} bootstrap --namespace=".$this->containerName()." 2>&1", $output);
            // dd($output); // to debug!!
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
            exec("cd {$this->containerFolder()} && {$this->codecept} generate:suite api");
        } else {
            session()->push('warning', 'Codeception tests already bootstraped!!');
        }
    }

    /**
     * Adds Laravel module for Codeception suite.
     *
     * @param string $suite   The codeception suite name
     * @param string $modules The modules to enable on suite
     */
    private function configureCodeceptSuite(string $suite, string $modules)
    {
        $suiteContent = file_get_contents($this->containerFolder()."/tests/$suite.suite.yml");

        // if the suit content has enabled the Laravel5 module, don't modify the file
        if (strpos($suiteContent, '- Laravel5:') === false) {
            $suiteContent .= $modules;
            file_put_contents($this->containerFolder()."/tests/$suite.suite.yml", $suiteContent);
        } else {
            session()->push('warning', "Codeception setup for $suite.suite.yml already set!!");
        }
    }

    public function copyRootBoostrapFile()
    {
        $fileContents = view($this->templatesDir().'.Porto.tests._bootstrap', [
            'gen' => $this,
            'fields' => $this->parsedFields
        ]);

        file_put_contents($this->testsFolder().'/_bootstrap.php', $fileContents);
    }

    public function generateEntityHelper()
    {
        $template = $this->templatesDir().'.Porto.tests._support.Helper.-entity-Helper';
        $fileName = str_replace('-entity-', $this->entityName(), '-entity-Helper.php');
        $filePath = $this->testsFolder().'/_support/Helper/'.$fileName;
        
        $fileContents = view($template, [
            'gen' => $this,
            'fields' => $this->parsedFields
        ]);

        file_put_contents($filePath, $fileContents);
    }

    /**
     * Returns the modules to enable on Codeception API suite.
     *
     * @return string
     */
    private function getApiSuiteModules()
    {
        return "\n".
            "        - \\{$this->containerName()}\Helper\\{$this->entityName()}Helper\n".
            "        - \App\Ship\Tests\Codeception\UserHelper\n".
            "        - \App\Ship\Tests\Codeception\HashidsHelper\n".
            "        - Asserts\n".
            "        - REST:\n".
            "            depends: Laravel5\n".
            "        - Laravel5:\n".
            "            root: ../../../\n".
            "            environment_file: .env.testing\n".
            "            run_database_migrations: true\n".
            '            url: "'.env('API_URL').'"';
    }

    /**
     * Returns the modules to enable on Codeception functional suite.
     *
     * @return string
     */
    private function getFunctionalSuiteModules()
    {
        return "\n".
            "        - \\{$this->containerName()}\Helper\\{$this->entityName()}Helper\n".
            "        - \App\Ship\Tests\Codeception\UserHelper\n".
            "        - Asserts\n".
            "        - Laravel5:\n".
            "            environment_file: .env.testing\n".
            "            root: ../../../\n".
            '            run_database_migrations: true';
    }

    private function generateApiTests()
    {
        $this->createEntityApiTestsFolder();

        foreach ($this->files as $file) {
            // prevent to create Restore test if table hasn't SoftDelete column
            if (str_contains($file, ['Restore']) && !$this->hasSoftDeleteColumn) {
                continue;
            }

            $plural = ($file == 'ListAndSearch') ? true : false;
            $atStart = in_array($file, ['FormData', 'FormModel']) ? true : false;

            $testFile = $this->apiTestsFolder()."/{$this->entityName()}/".$this->apiTestFile($file, $plural, $atStart);
            $template = $this->templatesDir().'.Porto/tests/api/'.$file;

            $content = view($template, [
                'gen' => $this,
                'fields' => $this->parsedFields
            ]);

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
