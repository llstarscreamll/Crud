<?php

namespace App\Containers\Crud\Tasks;

use Illuminate\Support\Collection;
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
        'Delete',
        'FormModel',
        'Get',
        'ListAndSearch',
        'Restore',
        'SelectListFrom',
        'Update',
    ];

    /**
     * The parsed fields from request.
     *
     * @var Illuminate\Support\Collection
     */
    public $parsedFields;

    /**
     * Create new CreateCodeceptionTestsTask instance.
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
     * @param string $container Contaner name
     *
     * @return bool
     */
    public function run()
    {
        $this->configureCodeceptSuite('api', $this->getApiSuiteModules());
        $this->configureCodeceptSuite('functional', $this->getFunctionalSuiteModules());
        $this->copyRootBoostrapFile();
        $this->generateHelper();

        $this->generateApiTests();

        return true;
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
            'crud' => $this,
            'fields' => $this->parsedFields
        ]);

        file_put_contents($this->testsFolder().'/_bootstrap.php', $fileContents);
    }

    public function generateHelper()
    {
        $fileName = str_replace('-container-', $this->containerName(), '-container-Helper.php');
        $filePath = $this->testsFolder().'/_support/Helper/'.$fileName;

        $fileContents = $this->getHelperClassContents();
        
        $fileContents = $this->addMethodToHelper($fileContents);
        $fileContents = $this->addUseStatementsToHelperClass($fileContents);

        file_put_contents($filePath, $fileContents);
    }

    /**
     * Returns the ContainerHelper class file contents if exists, or creates a
     * new one otherwise.
     *
     * @return string
     */
    public function getHelperClassContents(): string
    {
        $fileName = str_replace('-container-', $this->containerName(), '-container-Helper.php');
        $filePath = $this->testsFolder().'/_support/Helper/'.$fileName;

        if (file_exists($filePath)) {
            return file_get_contents($filePath);
        }

        $template = $this->templatesDir().'.Porto.tests._support.Helper.-container-Helper';
        
        return (string) view($template, [
            'crud' => $this,
            'fields' => $this->parsedFields
        ]);
    }

    /**
     * Add the entity method to the ContainerHelper class, the generated method
     * init the required base data to run the tests, like seed the database with
     * entity permissions seeder and create related models with factories.
     *
     * @param string $helperFileContents
     * @return string
     */
    public function addMethodToHelper(string $helperFileContents): string
    {
        $search = "\Codeception\Module\n{";
        $methodTemplate = $this->templatesDir().'.Porto.tests._support.Helper.helperFunction';
        $helperMethodName = "function init{$this->entityName()}Data";
        $fullMethod = "\n    ".view($methodTemplate, [
            'crud' => $this,
            'fields' => $this->parsedFields
        ]);

        if (strrpos($helperFileContents, $helperMethodName) === false) {
            $helperFileContents = str_replace($search, $search.$fullMethod, $helperFileContents);
        }

        return $helperFileContents;
    }

    /**
     * Add use statements to ContainerHelper class, mainly entity permissions
     * seeder.
     *
     * @param string $helperFileContents
     * @return string
     */
    public function addUseStatementsToHelperClass(string $helperFileContents): string
    {
        $search = "use Illuminate\Support\Facades\Artisan;";
        $seederNamespace = "use App\Containers\\".$this->containerName()."\Data\Seeders\\".$this->entityName()."PermissionsSeeder;";

        // add entity seeder class namespace
        if (strpos($helperFileContents, $seederNamespace) === false) {
            $helperFileContents = str_replace($search, $seederNamespace."\n".$search, $helperFileContents);
        }

        return $helperFileContents;
    }

    /**
     * Returns the modules to enable on Codeception API suite.
     *
     * @return string
     */
    private function getApiSuiteModules()
    {
        return "\n".
            "        - \\{$this->containerName()}\Helper\\{$this->containerName()}Helper\n".
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
            "        - \\{$this->containerName()}\Helper\\{$this->containerName()}Helper\n".
            "        - \App\Ship\Tests\Codeception\UserHelper\n".
            "        - \App\Ship\Tests\Codeception\HashidsHelper\n".
            "        - Asserts\n".
            "        - Laravel5:\n".
            "            environment_file: .env.testing\n".
            "            root: ../../../\n".
            '            run_database_migrations: true';
    }

    /**
     * Generate API test suit class files.
     */
    private function generateApiTests()
    {
        $this->createEntityApiTestsFolder();

        foreach ($this->files as $file) {
            // prevent to create Restore test if table hasn't SoftDelete column
            if (str_contains($file, ['Restore']) && !$this->hasSoftDeleteColumn) {
                continue;
            }

            $plural = ($file == 'ListAndSearch') ? true : false;
            $atStart = in_array($file, ['FormModel']) ? true : false;

            $testFile = $this->apiTestsFolder()."{$this->solveGroupClasses('d')}/".$this->apiTestFile($file, $plural, $atStart);
            $template = $this->templatesDir().'.Porto/tests/api/'.$file;

            $content = view($template, [
                'crud' => $this,
                'fields' => $this->parsedFields
            ]);

            file_put_contents($testFile, $content) === false
                ? session()->push('error', "Error creating $file api test file")
                : session()->push('success', "$file api test creation success");
        }
    }

    /**
     * Creates the API entity tests folder if desired.
     */
    private function createEntityApiTestsFolder()
    {
        if (!file_exists($this->apiTestsFolder().'/'.$this->entityName()) && $this->request->get('group_main_apiato_classes', false)) {
            mkdir($this->apiTestsFolder().'/'.$this->entityName(), null, true);
        }
    }
}
