<?php

namespace LaraWP\Foundation\Bootstrap;

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidFileException;
use LaraWP\Contracts\Foundation\Application;
use LaraWP\Support\Env;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

class LoadEnvironmentVariables
{
    /**
     * Bootstrap the given application.
     *
     * @param \LaraWP\Contracts\Foundation\Application $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        if ($app->configurationIsCached()) {
            return;
        }

        $this->checkForSpecificEnvironmentFile($app);

        try {
            $this->createDotenv($app)->safeLoad();
        } catch (InvalidFileException $e) {
            $this->writeErrorAndDie($e);
        }
    }

    /**
     * Detect if a custom environment file matching the APP_ENV exists.
     *
     * @param \LaraWP\Contracts\Foundation\Application $app
     * @return void
     */
    protected function checkForSpecificEnvironmentFile($app)
    {
        if ($app->runningInConsole() && ($input = new ArgvInput)->hasParameterOption('--env')) {
            if ($this->setEnvironmentFilePath(
                $app, $app->environmentFile() . '.' . $input->getParameterOption('--env')
            )) {
                return;
            }
        }

        $environment = Env::get('APP_ENV');

        if (!$environment) {
            return;
        }

        $this->setEnvironmentFilePath(
            $app, $app->environmentFile() . '.' . $environment
        );
    }

    /**
     * Load a custom environment file.
     *
     * @param \LaraWP\Contracts\Foundation\Application $app
     * @param string $file
     * @return bool
     */
    protected function setEnvironmentFilePath($app, $file)
    {
        if (is_file($app->environmentPath() . '/' . $file)) {
            $app->loadEnvironmentFrom($file);

            return true;
        }

        return false;
    }

    /**
     * Create a Dotenv instance.
     *
     * @param \LaraWP\Contracts\Foundation\Application $app
     * @return \Dotenv\Dotenv
     */
    protected function createDotenv($app)
    {
        return Dotenv::create(
            Env::getRepository(),
            $app->environmentPath(),
            $app->environmentFile()
        );
    }

    /**
     * Write the error information to the screen and exit.
     *
     * @param \Dotenv\Exception\InvalidFileException $e
     * @return void
     */
    protected function writeErrorAndDie(InvalidFileException $e)
    {
        $output = (new ConsoleOutput)->getErrorOutput();

        $output->writeln('The environment file is invalid!');
        $output->writeln($e->getMessage());

        exit(1);
    }
}
