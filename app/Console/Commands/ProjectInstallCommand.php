<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProjectInstallCommand extends Command
{
    protected $signature = 'project:install';
    protected $description = 'Set up initial project configuration';

    public function handle(): void
    {
        $this->info('Setting up project permissions...');

        $commands = [
            'chmod -R 775 storage/',
            'chmod -R 775 bootstrap/cache/',
            'chown -R www-data:www-data storage/',
            'chown -R www-data:www-data bootstrap/cache/',
            'php artisan storage:link',
            'touch database/database.sqlite',
            'chmod 775 database/database.sqlite',
        ];

        foreach ($commands as $command) {
            $this->executeCommand($command);
        }

        $this->info('Project setup completed successfully!');
    }

    private function executeCommand($command): void
    {
        $this->info("Executing: {$command}");
        exec($command, $output, $returnCode);

        if ($returnCode === 0) {
            $this->info('✓ Success');
        } else {
            $this->error('✗ Failed');
        }
    }
}
