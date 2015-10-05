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
        $outputFolder = 'angular/app/' . $name;

        $stubController = $this->fs->get('app/Core/Console/Commands/Angular/stubs/feature/controller.js.stub');
        // $stubController = file_get_contents(__DIR__ . '/stubs/feature/controller.js.stub');

        $controllerContent = str_replace(
            "{{Stubname}}",
            studly_case($name),
            $stubController
        );

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
    }

    /**
     * Append a new sass import to the application main sass file.
     *
     * @param  string $name
     * @return void
     */
    private function appendStylesheet($name)
    {
        $mainStyles = 'angular/main.scss';

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
