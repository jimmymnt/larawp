<?php

namespace LaraPress\Queue\Middleware;

use LaraPress\Container\Container;
use LaraPress\Contracts\Redis\Factory as Redis;
use LaraPress\Redis\Limiters\DurationLimiter;
use LaraPress\Support\InteractsWithTime;
use Throwable;

class ThrottlesExceptionsWithRedis extends ThrottlesExceptions
{
    use InteractsWithTime;

    /**
     * The Redis factory implementation.
     *
     * @var \LaraPress\Contracts\Redis\Factory
     */
    protected $redis;

    /**
     * The rate limiter instance.
     *
     * @var \LaraPress\Redis\Limiters\DurationLimiter
     */
    protected $limiter;

    /**
     * Process the job.
     *
     * @param mixed $job
     * @param callable $next
     * @return mixed
     */
    public function handle($job, $next)
    {
        $this->redis = Container::getInstance()->make(Redis::class);

        $this->limiter = new DurationLimiter(
            $this->redis, $this->getKey($job), $this->maxAttempts, $this->decayMinutes * 60
        );

        if ($this->limiter->tooManyAttempts()) {
            return $job->release($this->limiter->decaysAt - $this->currentTime());
        }

        try {
            $next($job);

            $this->limiter->clear();
        } catch (Throwable $throwable) {
            if ($this->whenCallback && !call_user_func($this->whenCallback, $throwable)) {
                throw $throwable;
            }

            $this->limiter->acquire();

            return $job->release($this->retryAfterMinutes * 60);
        }
    }
}
