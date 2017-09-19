<?php

namespace App\Containers\Crud\Traits;

use stdClass;

/**
* AngularFolderNamesResolver Trait.
*/
trait AngularFolderNamesResolver
{
    /**
     * TODO: this method is duplicated, fix it.
     */
    public function templatesDir()
    {
        return config('crudconfig.templates');
    }

    /**
     * TODO: this method is duplicated, fix it.
     */
    public function relationNameFromField(stdClass $field)
    {
        $functionName = camel_case(str_replace('_id', '', $field->name));

        // singular name
        if (in_array($field->relation, ['belongsTo', 'hasOne'])) {
            $functionName = str_singular($functionName);
        }

        // plural name
        if (in_array($field->relation, ['hasMany', 'belongsToMany'])) {
            $functionName = str_plural($functionName);
        }

        return $functionName;
    }

    // duplicated method!
    public function outputDir()
    {
        return config('crudconfig.output_folder');
    }
    // duplicated method!
    public function codeOutputDir()
    {
        return $this->outputDir().'code/';
    }

    public function angularDir()
    {
        return $this->codeOutputDir().'Angular2';
    }

    /**
     * TODO: this method is duplicated, fix it.
     */
    public function entityName($plural = false)
    {
        $entity = $plural
            ? str_plural($this->tableName)
            : str_singular($this->tableName);

        return studly_case($entity);
    }

    public function entityNameUppercase($plural = false)
    {
        return strtoupper($this->entityName());
    }

    public function entityNameSnakeCase($plural = false)
    {
        $entity = $plural
            ? str_plural($this->tableName)
            : str_singular($this->tableName);

        return strtoupper(snake_case($entity));
    }

    public function slugEntityName($plural = false)
    {
        $entity = $plural
            ? str_plural($this->tableName)
            : str_singular($this->tableName);

        return str_slug($entity, '-');
    }

    public function ngSlugModuleFromNamespace(string $namespace, bool $plural = false)
    {
        $module = str_replace('App\Containers\\', '', $namespace);
        $start = strpos($module, '\\');
        $module = substr($module, 0, $start);

        $module = $plural
            ? str_plural($module)
            : str_singular($module);

        $module = snake_case($module);

        return str_slug($module, '-');
    }

    public function slugModuleName($plural = false)
    {
        $module = $plural
            ? str_plural($this->container)
            : str_singular($this->container);

        $module = snake_case($module);

        return str_slug($module, '-');
    }

    public function studlyModuleName($plural = false)
    {
        $module = $plural
            ? str_plural($this->container)
            : str_singular($this->container);

        $module = studly_case($module);

        return $module;
    }

    /**
     * TODO: duplicated method!! refactor this!!
     */
    public function containerName()
    {
        return studly_case(str_singular($this->container));
    }

    public function getLanguageKey(bool $upper = false)
    {
        $key = $upper
            ? strtoupper($this->request->get('language_key'))
            : strtolower($this->request->get('language_key'));

        return $key;
    }

    public function moduleDir()
    {
        // let's work on the real Angular app dir
        return $this->request->get('angular_module_location').$this->slugModuleName();
    }

    public function modelsDir()
    {
        return $this->moduleDir().'/models';
    }

    public function actionsDir()
    {
        return $this->moduleDir().'/actions';
    }

    public function utilsDir()
    {
        return $this->moduleDir().'/utils';
    }

    public function utilFile(string $file)
    {
        $entity = $this->slugEntityName();
        $file = str_replace('-entity-', $entity, $file);

        return $file.'.util.ts';
    }

    public function reducersDir()
    {
        return $this->moduleDir().'/reducers';
    }

    public function effectsDir()
    {
        return $this->moduleDir().'/effects';
    }

    public function routesDir()
    {
        return $this->moduleDir().'/routes';
    }

    public function servicesDir()
    {
        return $this->moduleDir().'/services';
    }

    public function componentsDir()
    {
        return $this->moduleDir().'/components/'.$this->slugEntityName();
    }

    public function componentFile($file, $plural = false)
    {
        if ($file == "index") {
            return $file.'.ts';
        }

        $ext = $this->solveExtentionFormFile($file, '.component');
        $file = $this->cleanFileName($file);
        $entity = $this->slugEntityName($plural);

        return $entity.'-'.$file.$ext;
    }

    public function componentClass($class, $plural = false)
    {
        $class = studly_case($class);
        $entity = $this->entityName($plural);
        return $entity.$class."Component";
    }

    public function containersDir()
    {
        return $this->moduleDir().'/pages/'.$this->slugEntityName();
    }

    public function translationsDir()
    {
        return $this->moduleDir().'/translations/'.$this->getLanguageKey();
    }

    public function configDir()
    {
        return $this->moduleDir().'/config/';
    }

    public function containerFile($file, $plural = false, bool $atStart = false)
    {
        if ($file == "index") {
            return $file.'.ts';
        }

        $ext = $this->solveExtentionFormFile($file, ".page");
        $file = $this->cleanFileName($file);
        $entity = $this->slugEntityName($plural);

        $baseName = $atStart
            ? $entity.'-'.$file
            : $file.'-'.$entity;

        return $baseName.$ext;
    }

    public function containerClass($class, $plural = false, bool $atStart = false)
    {
        $class = studly_case($class);
        $entity = $this->entityName($plural);

        $baseName = $atStart
            ? $entity.$class
            : $class.$entity;

        return $baseName."Page";
    }

    public function solveExtentionFormFile($file, $prefix = '.component')
    {
        $ext = ".ts";

        $ext = (strpos($file, "-spec") === false)
            ? $ext
            : ".spec.ts";

        $ext = (strpos($file, "-css") === false)
            ? $ext
            : ".css";

        $ext = (strpos($file, "-html") === false)
            ? $ext
            : ".html";

        return $prefix.$ext;
    }

    public function cleanFileName($file)
    {
        $file = str_replace('-css', '', $file);
        $file = str_replace('-html', '', $file);
        $file = str_replace('-spec', '', $file);

        return $file;
    }

    public function moduleFile($file)
    {
        $file = $file === "module" ? '' : '-'.$file;
        $module = $this->slugModuleName();

        return $module.$file.".module.ts";
    }

    public function moduleClass($class)
    {
        $class = $class === "module" ? '' : $class;
        $class = studly_case($class);
        $entity = $this->entityName();

        return $this->studlyModuleName().$class."Module";
    }
}
