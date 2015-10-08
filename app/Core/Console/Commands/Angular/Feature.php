<?php

namespace App\Core\Console\Commands\Angular;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Console\Command;

class Feature extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ng:feature {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new angular feature.';

    /**
     * The filesystem instance.
     *
     * @var Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $fs;

    /**
     * Create a new command instance.
     */
    public function __construct(Filesystem $fs)
    {
        parent::__construct();

        $this->fs = $fs;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = mb_strtolower($this->argument('name'));
        $outputFolder = base_path('angular/app/' . $name);

        $stubController = $this->fs->get(__DIR__ . '/stubs/feature/controller.js.stub');
        $stubModule = $this->fs->get(__DIR__ . '/stubs/feature/module.js.stub');

        $controllerContent = str_replace(
            "{{Stubname}}",
            studly_case($name),
            $stubController
        );

        $controllerContent = str_replace(
            "{{Modulename}}",
            camel_case($name),
            $controllerContent
        );

        $moduleContent = str_replace(
            "{{Modulename}}",
            camel_case($name),
            $stubModule
        );

        // Create the feature directory
        $this->fs->makeDirectory($outputFolder);

        // Save the feature controller
        $this->fs->put(
            sprintf("%s/%s.controller.js", $outputFolder, $name),
            $controllerContent
        );

        $this->fs->put(
            sprintf("%s/%s.module.js", $outputFolder, $name),
            $moduleContent
        );

        // Save the feature html view
        $this->createEmptyFile($outputFolder, $name . ".html");

        // Save the feature specific style sheet
        $this->createEmptyFile($outputFolder, $name . ".scss");

        // Update the main style sheet.
        $this->appendStylesheet($name);
    }

    /**
     * Append a new sass import to the application main sass file.
     *
     * @param  string $name
     * @return void
     */
    private function appendStylesheet($name)
    {
        $mainStyles = base_path('angular/main.scss');

        $import = sprintf('@import "app/%s/%s";', $name, $name) . PHP_EOL;

        $this->fs->append($mainStyles, $import);
    }

    /**
     * Create an empty file for the feature.
     *
     * @param  string $folder
     * @param  string $filename
     * @return void
     */
    private function createEmptyFile($folder, $name)
    {
        $this->fs->put(
            sprintf("%s/%s", $folder, $name),
            ""
        );
    }
}
