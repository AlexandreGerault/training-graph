<?php

namespace Shared\Infrastructure\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Blade::componentNamespace('Shared\\UI\\Components', 'shared');
    }
}
