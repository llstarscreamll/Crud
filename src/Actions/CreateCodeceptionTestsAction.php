<?php

namespace llstarscreamll\Crud\Actions;

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
    public $container = '';

    /**
     * The tests files to generate.
     *
     * @var array
     */
    public $files = [];

    /**
     * @param string $container Contaner name
     *
     * @return bool
     */
    public function run(string $container)
    {
        $this->container = studly_case($container);
        $containerFolder = $this->containerFolder();

        // bootstraps Codeception on container
        if (!file_exists($this->testsFolder())) {
            exec("cd $containerFolder && codecept bootstrap --namespace=".$this->containerName());
        } else {
            session()->push('warning', 'Codeception tests already bootstraped!!');
        }

        // create suit for API tests
        if (!file_exists($this->apiTestsFolder())) {
            exec("cd $containerFolder && codecept generate:suite api");
        } else {
            session()->push('warning', 'Codeception tests already bootstraped!!');
        }

        $this->configureCodeceptSuite('api');
        $this->configureCodeceptSuite('functional');

        // builds Codeception suites
        exec("cd $containerFolder && codecept build");

        return true;
    }

    /**
     * Adds Laravel module for Codeception suite.
     *
     * @param  string $suite The codeception suite name
     * @return void
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
            "            run_database_migrations: true";
    }

    private function generateApiTests()
    {
        foreach ($this->files as $file) {
            $plural = ($file == "ListAll") ? true : false;

            $actionFile = $this->apiRequestsFolder().'/'.$this->apiRequestFile($file, $plural);
            $template = $this->templatesDir().'.Porto/UI/API/Requests/'.$file;

            $content = view($template, ['gen' => $this]);

            file_put_contents($actionFile, $content) === false
                ? session()->push('error', "Error creating $file request file")
                : session()->push('success', "$file request creation success");
        }
    }
}
