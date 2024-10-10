<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Support\Facades\View;

class HeadScriptServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $codeHeadScript = Setting::where('key', 'code-head')->value('value');
        $codeBodyScript = Setting::where('key', 'code-body')->value('value');
        View::share('codeHeadScript', $codeHeadScript);
        View::share('codeBodyScript', $codeBodyScript);
    }
}
