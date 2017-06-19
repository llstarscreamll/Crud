<?php

namespace App\Containers\Crud\Tasks;

use App\Containers\Crud\Traits\FolderNamesResolver;

/**
 * CreateComposerFileTask Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class CreateComposerFileTask
{
    use FolderNamesResolver;

    /**
     * Container name to generate.
     *
     * @var string
     */
    public $container = '';

    /**
     * @param string $container Contaner name
     *
     * @return bool
     */
    public function run(string $container)
    {
        $this->container = studly_case($container);

        $composerFile = $this->containerFolder().'/composer.json';
        $template = $this->templatesDir().'.Porto/composer';

        $content = view($template, ['crud' => $this]);

        file_put_contents($composerFile, $content) === false
            ? session()->push('error', 'Error creating composer file')
            : session()->push('success', 'Composer file creation success');

        return true;
    }
}
