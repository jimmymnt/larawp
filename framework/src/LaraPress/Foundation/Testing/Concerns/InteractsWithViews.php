<?php

namespace LaraPress\Foundation\Testing\Concerns;

use LaraPress\Support\Facades\View as ViewFacade;
use LaraPress\Support\MessageBag;
use LaraPress\Support\ViewErrorBag;
use LaraPress\Testing\TestComponent;
use LaraPress\Testing\TestView;
use LaraPress\View\View;

trait InteractsWithViews
{
    /**
     * Create a new TestView from the given view.
     *
     * @param string $view
     * @param \LaraPress\Contracts\Support\Arrayable|array $data
     * @return \LaraPress\Testing\TestView
     */
    protected function view(string $view, array $data = [])
    {
        return new TestView(lp_view($view, $data));
    }

    /**
     * Render the contents of the given Blade template string.
     *
     * @param string $template
     * @param \LaraPress\Contracts\Support\Arrayable|array $data
     * @return \LaraPress\Testing\TestView
     */
    protected function blade(string $template, array $data = [])
    {
        $tempDirectory = sys_get_temp_dir();

        if (!in_array($tempDirectory, ViewFacade::getFinder()->getPaths())) {
            ViewFacade::addLocation(sys_get_temp_dir());
        }

        $tempFileInfo = pathinfo(tempnam($tempDirectory, 'laravel-blade'));

        $tempFile = $tempFileInfo['dirname'] . '/' . $tempFileInfo['filename'] . '.blade.php';

        file_put_contents($tempFile, $template);

        return new TestView(lp_view($tempFileInfo['filename'], $data));
    }

    /**
     * Render the given view component.
     *
     * @param string $componentClass
     * @param \LaraPress\Contracts\Support\Arrayable|array $data
     * @return \LaraPress\Testing\TestComponent
     */
    protected function component(string $componentClass, array $data = [])
    {
        $component = $this->app->make($componentClass, $data);

        $view = lp_value($component->resolveView(), $data);

        $view = $view instanceof View
            ? $view->with($component->data())
            : lp_view($view, $component->data());

        return new TestComponent($component, $view);
    }

    /**
     * Populate the shared view error bag with the given errors.
     *
     * @param array $errors
     * @param string $key
     * @return $this
     */
    protected function withViewErrors(array $errors, $key = 'default')
    {
        ViewFacade::share('errors', (new ViewErrorBag)->put($key, new MessageBag($errors)));

        return $this;
    }
}
