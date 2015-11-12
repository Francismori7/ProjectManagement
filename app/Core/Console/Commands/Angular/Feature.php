<?php

namespace App\Core\Console\Commands\Angular;

use Illuminate\Contracts\Filesystem\Filesystem;
use App\Core\Console\Commands\Angular\AngularCommand;

class Feature extends AngularCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ng:module {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new angular module.';

    /**
     * Create a new command instance.
     */
    public function __construct(Filesystem $fs)
    {
        parent::__construct($fs);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->getModuleName();

        if ($this->moduleExists($name)) {
            $this->error("That module already exists.");
            return;
        }

        $outputFolder = base_path('angular/app/' . $name);

        $stubController = $this->fs->get(__DIR__ . '/stubs/feature/controller.js.stub');

        $controllerContent = $this->parseStubname($stubController, $name);
        $controllerContent = $this->parseModulename($controllerContent, $name);

        // Create the feature directory
        $this->fs->makeDirectory($outputFolder);

        // Save the feature controller
        $this->fs->put(
            sprintf("%s/%s.controller.js", $outputFolder, $name),
            $controllerContent
        );

        // Save the feature html view
        $this->createEmptyFile($outputFolder, $name . ".html");

        // Save the feature specific style sheet
        $this->createEmptyFile($outputFolder, $name . ".scss");

        // Update the main style sheet.
        $this->appendStylesheet($name);

        // Register the module
        $this->registerModule($name);
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
