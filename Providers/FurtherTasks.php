<?php

namespace llstarscreamll\Crud\Providers;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class FurtherTasks extends BaseGenerator
{
    /**
     * Genera los tests o pruebas funcionales del CRUD a crear.
     *
     * @return bool
     */
    public function run()
    {
        // ejecutamos composer dumpautoload
        ($command = $this->executeComposerDumpAutoload())
            ? session()->push('error', 'Ocurrió un error ejecutando composer dumpautoload.')
            : session()->push('success', 'composer dumpautoload exitoso: '.$command);

        return true;
    }

    /**
     * Ejecuta el comando composer dumpautoload.
     *
     * @return bool|string
     */
    public function executeComposerDumpAutoload()
    {
        // la variable COMPOSER_HOME=".composer" es asignada en la ejecución
        // para prevenir el error:
        // "HOME or COMPOSER_HOME environment variable must be set for composer
        // to run correctly"
        // Leer mas sobr este error aquí:
        // https://github.com/composer/packagist/issues/393
        // https://github.com/composer/composer/issues/4789
        // Leer mas sobre la solución que implementé, aquí:
        // http://askubuntu.com/questions/344687/how-to-set-environment-variable-before-running-script-inside-hooks-install

        $process = new Process('cd '.base_path().' && COMPOSER_HOME=".composer" composer dumpautoload');
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            // throw new ProcessFailedException($process);
            return false;
        }

        return $process->getOutput();
    }
}
