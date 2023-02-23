<?php

namespace LaraPress\Foundation\Console;

use LaraPress\Bus\Queueable;
use LaraPress\Contracts\Console\Kernel as KernelContract;
use LaraPress\Contracts\Queue\ShouldQueue;
use LaraPress\Foundation\Bus\Dispatchable;

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
     * @param \LaraPress\Contracts\Console\Kernel $kernel
     * @return void
     */
    public function handle(KernelContract $kernel)
    {
        $kernel->call(...array_values($this->data));
    }
}
