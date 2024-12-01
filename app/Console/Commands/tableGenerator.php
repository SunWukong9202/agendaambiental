<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class tableGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:table-config {class}';

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'class' => 'please provide the name of the class to create',
        ];
    }

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a new default table configuration of a filament table for an specific model';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the name of the class
        $path = $this->argument('class');

        $parts = explode('/', $path);
        
        $parts = $parts[0] == $path ? explode('\\', $path) : $parts;

        $last = count($parts) - 1;

        $name = $parts[$last];

        $namespace = implode("\\", array_slice($parts, 0, $last));
        
        // Specify the path for your custom stub file
        $stubPath = base_path('stubs/table_conf_class.stub');

        // Check if the stub exists
        if (!File::exists($stubPath)) {
            $this->error('Stub file does not exist at ' . $stubPath);
            return;
        }

        // Get the content of the stub
        $stub = File::get($stubPath);

        // Replace the {{ class }} placeholder with the class name
        $stub = str_replace('{{ class }}', $name, $stub);

        // Define the path where the new class will be generated
        $filePath = app_path('Livewire/' . $path . '.php');

        $stub = str_replace('{{ namespace }}', app_path('Livewire\\') . $namespace, $stub);

        // Create the directory if it doesn't exist
        $directory = dirname($filePath);
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0777, true);
        }

        // Write the class to the file
        File::put($filePath, $stub);

        $this->info("Custom class '$name' has been generated successfully!");
    }
}
