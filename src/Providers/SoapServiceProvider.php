<?php

namespace RicorocksDigitalAgency\Soap\Providers;

use Illuminate\Support\ServiceProvider;
use RicorocksDigitalAgency\Soap\Parameters\Builder;
use RicorocksDigitalAgency\Soap\Parameters\IntelligentBuilder;
use RicorocksDigitalAgency\Soap\Ray\SoapWatcher;
use RicorocksDigitalAgency\Soap\Request\Request;
use RicorocksDigitalAgency\Soap\Request\SoapClientRequest;
use RicorocksDigitalAgency\Soap\Soap;

class SoapServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('soap', fn() => app(Soap::class));
        $this->app->bind(Request::class, SoapClientRequest::class);
        $this->app->bind(Builder::class, IntelligentBuilder::class);

        $this->registerRay();
    }

    public function boot()
    {
        require_once __DIR__ . '/../helpers.php';
    }

    protected function registerRay()
    {
        if (!SoapWatcher::rayExists()) {
            return;
        }

        $this->app->singleton(SoapWatcher::class);
        app(SoapWatcher::class)->register();
    }
}
