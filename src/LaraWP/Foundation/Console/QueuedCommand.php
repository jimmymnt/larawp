<?php

namespace LaraWP\Foundation\Console;

use LaraWP\Bus\Queueable;
use LaraWP\Contracts\Console\Kernel as KernelContract;
use LaraWP\Contracts\Queue\ShouldQueue;
use LaraWP\Foundation\Bus\Dispatchable;

class QueuedCommand implements ShouldQueue
{
    use Dispatchable, Queueable;

    /**
     * The data to pass to the Artisan command.
     *
     * @var array
     */
    protected $data;

    /**
     * Create a new job instance.
     *
     * @param array $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Handle the job.
     *
     * @param \LaraWP\Contracts\Console\Kernel $kernel
     * @return void
     */
    public function handle(KernelContract $kernel)
    {
        $kernel->call(...array_values($this->data));
    }
}
