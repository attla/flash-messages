<?php

namespace Attla\Flash;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the service provider
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->configPath(), 'flash-messages');

        $this->app->singleton('flash', fn () => $this->app->make(Factory::class));
    }

    /**
     * Bootstrap the application events
     *
     * @return void
     */
    public function boot()
    {
        $this->registerDiretives();

        $this->publishes([
            $this->configPath() => $this->app->configPath('flash-messages.php'),
        ], 'attla/flash-messages/config');

        $this->loadViewsFrom(__DIR__ . '/../views/', 'flash');
    }

    /**
     * Register the flash blade directives
     *
     * @param void
     */
    protected function registerDiretives()
    {
        $blade = $this->app['blade.compiler'];

        $blade->directive('message', $message = $this->diretiveCallable('message'));
        $blade->directive('messages', $message);
        $blade->directive('flash', $message);
        $blade->directive('flash-message', $message);
        $blade->directive('flash-messages', $message);

        $blade->directive('error', $error = $this->diretiveCallable('error'));
        $blade->directive('errors', $error);
    }

    /**
     * Register the flash blade directives
     *
     * @param void
     */
    protected function diretiveCallable($view)
    {
        return function ($expression) use ($view) {
            return '<?php echo $__env->make(\'flash::' . $view . '\', ' . ($expression ?: '[]') . ', '
                . '\Illuminate\Support\Arr::except(get_defined_vars(), [\'__data\', \'__path\']))->render(); ?>';
        };
    }

    /**
     * Get config path
     *
     * @param bool
     */
    protected function configPath()
    {
        return __DIR__ . '/../config/flash-messages.php';
    }
}
