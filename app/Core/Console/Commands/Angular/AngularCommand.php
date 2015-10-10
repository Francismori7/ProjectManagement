<?php

namespace App\Core\Console\Commands\Angular;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Console\Command;

abstract class AngularCommand extends Command
{
    /**
     * The filesystem instance.
     *
     * @var Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $fs;

    /**
     * Create a new command instance.
     *
     * @param Illuminate\Contracts\Filesystem\Filesystem
     */
    public function __construct(Filesystem $fs)
    {
        parent::__construct();

        $this->fs = $fs;
    }

    /**
     * Parse the angular module name and add it to the stub.
     *
     * @param  string $stub
     * @param  string $name
     * @return string
     */
    protected function parseModulename($stub, $name)
    {
        return str_replace(
            "{{Modulename}}",
            camel_case($name),
            $stub
        );
    }

    /**
     * Parse the stub name and add it to the stub.
     *
     * @param  string $stub
     * @param  string $name
     * @return string
     */
    protected function parseStubname($stub, $name)
    {
        return str_replace(
            "{{Stubname}}",
            studly_case($name),
            $stub
        );
    }

    /**
     * Get the name of the object you want to create.
     *
     * @return string
     */
    protected function getModuleName()
    {
        return mb_strtolower($this->argument('module'));
    }

    /**
     * Check if a module exists.
     *
     * @param  string $name
     * @return boolean
     */
    protected function moduleExists($name)
    {
        $modules = $this->fs->get(base_path('angular/app/app.module.js'));
        $name = str_replace(".", "\.", $name);
        $pattern = "/angular\.module\(\'app\.$name\'\, \[.*\]\);/";

        return preg_match($pattern, $modules);
    }

    /**
     * Register a new module in the app.module.js file.
     *
     * @param  string $name
     * @return void
     */
    protected function registerModule($name)
    {
        $modules = $this->fs->get(base_path('angular/app/app.module.js'));
        $modulename = "'app.$name'";
        $moduleDef = "angular.module($modulename, []);" . PHP_EOL;

        $addedDef = substr_replace(
            $modules,
            "\t" . $moduleDef,
            strpos($modules, '/* @defineNgModule */'),
            0
        );

        $addedAsDep = substr_replace(
            $addedDef,
            "\t\t" . $modulename . ',' . PHP_EOL,
            strpos($addedDef, '/* @registerNgModule */'),
            0
        );

        $this->fs->put(
            base_path('angular/app/app.module.js'),
            $addedAsDep
        );
    }
}
