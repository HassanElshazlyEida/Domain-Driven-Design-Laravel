<?php

namespace App\Console\Commands;

use Domain\Shared\Models\User;
use Illuminate\Console\Command;
use Domain\Subscriber\Jobs\ImportSubscribersJob;

class ImportSubscribersCommand extends Command
{
    protected $signature = 'subscriber:import {user? : The ID of the user}';
    protected $description = 'Import subscribers from csv';

    public function handle()
    {
        $userId = $this->argument('user') ?? $this->ask('User ID');

        ImportSubscribersJob::dispatch(
            storage_path('subscribers/subscribers.csv'),
            User::findOrFail($userId),
        );

        $this->info("Subscribers are being imported...");

        return self::SUCCESS;
    }
}
