<?php

namespace LaraPress\Foundation\Testing\Concerns;

use DateTimeInterface;
use LaraPress\Foundation\Testing\Wormhole;
use LaraPress\Support\Carbon;

trait InteractsWithTime
{
    /**
     * Begin travelling to another time.
     *
     * @param int $value
     * @return \LaraPress\Foundation\Testing\Wormhole
     */
    public function travel($value)
    {
        return new Wormhole($value);
    }

    /**
     * Travel to another time.
     *
     * @param \DateTimeInterface $date
     * @param callable|null $callback
     * @return mixed
     */
    public function travelTo(DateTimeInterface $date, $callback = null)
    {
        Carbon::setTestNow($date);

        if ($callback) {
            return lp_tap($callback(), function () {
                Carbon::setTestNow();
            });
        }
    }

    /**
     * Travel back to the current time.
     *
     * @return \DateTimeInterface
     */
    public function travelBack()
    {
        return Wormhole::back();
    }
}
