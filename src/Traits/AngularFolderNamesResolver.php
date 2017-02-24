<?php

namespace llstarscreamll\Crud\Traits;

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
        return config('modules.crud.config.templates');
    }

    public function angularDir()
    {
        return app_path('Angular2');
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

    public function slugEntityName($plural = false)
    {
        $entity = $plural
            ? str_plural($this->tableName)
            : str_singular($this->tableName);

        return str_slug($entity, '-');
    }

    public function moduleDir()
    {
        return $this->angularDir().'/'.$this->entityName();
    }

    public function componentsDir()
    {
        return $this->moduleDir().'/components';
    }

    public function componentFile($file, $plural = false)
    {
        $ext = $this->solveExtentintionFormFile($file);
        $file = $this->cleanFileName($file);
        $entity = $this->slugEntityName($plural);

        return $entity.'-'.$file.".component".$ext;
    }

    public function componentClass($class, $plural = false)
    {
        $class = studly_case($class);
        $entity = $this->entityName($plural);
        return $entity.$class."Component";
    }

    public function containersDir()
    {
        return $this->moduleDir().'/containers';
    }

    public function translationsDir()
    {
        return $this->moduleDir().'/translations';
    }

    public function containerFile($file, $plural = false)
    {
        $ext = $this->solveExtentintionFormFile($file);
        $file = $this->cleanFileName($file);
        $entity = $this->slugEntityName($plural);

        return $file.'-'.$entity.".page".$ext;
    }

    public function containerClass($class, $plural = false)
    {
        $class = studly_case($class);
        $entity = $this->entityName($plural);
        return $class.$entity."Page";
    }

    public function solveExtentintionFormFile($file)
    {
        $ext = ".ts";

        $ext = (strpos($file, "-css") === false)
            ? $ext
            : ".css";

        $ext = (strpos($file, "-html") === false)
            ? $ext
            : ".html";

        return $ext;
    }

    public function cleanFileName($file)
    {
        $file = str_replace('-css', '', $file);
        $file = str_replace('-html', '', $file);

        return $file;
    }

    public function moduleFile($file)
    {
        $file = $file === "module" ? '' : '-'.$file;
        $entity = $this->slugEntityName();

        return $entity.$file.".module.ts";
    }

    public function moduleClass($class)
    {
        $class = $class === "module" ? '' : $class;
        $class = studly_case($class);
        $entity = $this->entityName();

        return $this->entityName().$class."Module";
    }
}
