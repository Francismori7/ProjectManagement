<?php

namespace App\Core\Console\Commands\Angular;

use Illuminate\Contracts\Filesystem\Filesystem;
use App\Core\Console\Commands\Angular\AngularCommand;

class Service extends AngularCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ng:service {name} {module}';

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
        $module = $this->getModuleName();
        $name   = $this->argument('name');
        $outputFolder = base_path('angular/app/' . $module);

        $this->fs->makeDirectory($outputFolder);

        $serviceStub = $this->fs->get(__DIR__ . '/stubs/service/service.js.stub');
        $serviceContent = $this->parseModulename($serviceStub, $module);
        $serviceContent = $this->parseStubname($serviceContent, $name);

        $this->fs->put(
            $outputFolder . '/' . $name . '.js',
            $serviceContent
        );
    }
}
