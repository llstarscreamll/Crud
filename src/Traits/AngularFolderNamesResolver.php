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
    public function entityName()
    {
        return studly_case(str_singular($this->tableName));
    }

    public function slugEntityName()
    {
        return str_slug(str_singular($this->tableName), '-');
    }

    public function moduleDir()
    {
        return $this->angularDir().'/'.$this->entityName();
    }

    public function componentsDir()
    {
        return $this->moduleDir().'/components';
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
