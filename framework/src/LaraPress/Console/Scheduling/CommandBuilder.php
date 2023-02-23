<?php

namespace LaraPress\Console\Scheduling;

use LaraPress\Console\Application;
use LaraPress\Support\ProcessUtils;

class CommandBuilder
{
    /**
     * Build the command for the given event.
     *
     * @param \LaraPress\Console\Scheduling\Event $event
     * @return string
     */
    public function buildCommand(Event $event)
    {
        if ($event->runInBackground) {
            return $this->buildBackgroundCommand($event);
        }

        return $this->buildForegroundCommand($event);
    }

    /**
     * Build the command for running the event in the foreground.
     *
     * @param \LaraPress\Console\Scheduling\Event $event
     * @return string
     */
    protected function buildForegroundCommand(Event $event)
    {
        $output = ProcessUtils::escapeArgument($event->output);

        return $this->ensureCorrectUser(
            $event, $event->command . ($event->shouldAppendOutput ? ' >> ' : ' > ') . $output . ' 2>&1'
        );
    }

    /**
     * Build the command for running the event in the background.
     *
     * @param \LaraPress\Console\Scheduling\Event $event
     * @return string
     */
    protected function buildBackgroundCommand(Event $event)
    {
        $output = ProcessUtils::escapeArgument($event->output);

        $redirect = $event->shouldAppendOutput ? ' >> ' : ' > ';

        $finished = Application::formatCommandString('schedule:finish') . ' "' . $event->mutexName() . '"';

        if (lp_windolp_os()) {
            return 'start /b cmd /v:on /c "(' . $event->command . ' & ' . $finished . ' ^!ERRORLEVEL^!)' . $redirect . $output . ' 2>&1"';
        }

        return $this->ensureCorrectUser($event,
            '(' . $event->command . $redirect . $output . ' 2>&1 ; ' . $finished . ' "$?") > '
            . ProcessUtils::escapeArgument($event->getDefaultOutput()) . ' 2>&1 &'
        );
    }

    /**
     * Finalize the event's command syntax with the correct user.
     *
     * @param \LaraPress\Console\Scheduling\Event $event
     * @param string $command
     * @return string
     */
    protected function ensureCorrectUser(Event $event, $command)
    {
        return $event->user && !lp_windolp_os() ? 'sudo -u ' . $event->user . ' -- sh -c \'' . $command . '\'' : $command;
    }
}
