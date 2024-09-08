<?php

namespace Domain\Subscriber\Jobs;

use Illuminate\Bus\Queueable;
use Domain\Shared\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Domain\Subscriber\Actions\ImportSubscribersAction;

class ImportSubscribersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly string $path,
        private readonly User $user,
    ) {}

    public function handle()
    {
        ImportSubscribersAction::execute($this->path, $this->user);
    }
}