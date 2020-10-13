<?php

namespace Strix\Ui;

use Illuminate\Support\ServiceProvider;
use Strix\Ui\Commands\UiCommand;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Support\Facades\View;

class UiServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if (!defined('STRIX_PATH')) {
            define('STRIX_PATH', realpath(__DIR__ . '/../../'));
        }

        $this->registerBlade();
        $this->configurePublishing();
    }

    protected function registerBlade(): void
    {
        $viewPath = realpath(STRIX_PATH . '/resources/views');

        $mixManifestPath = realpath(STRIX_PATH . '/public/themes/Strix/mix-manifest.json');

        View::share('strixAssetVersion', md5_file($mixManifestPath));

        $this->loadViewsFrom($viewPath, 'strix');

        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) {
            /** @var BladeComponent $component */
            foreach (config('strix.components') as $alias => $component) {
                $blade->component($component, $alias, null);
            }
        });
    }

    /**
     * Configure publishing for the package.
     *
     * @return void
     */
    protected function configurePublishing(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            realpath(STRIX_PATH . '/resources/views') => resource_path('views'),
        ], 'strix-views');

        $this->publishes([
            realpath(STRIX_PATH . '/public') => public_path(),
        ], 'strix-assets');
    }
}
