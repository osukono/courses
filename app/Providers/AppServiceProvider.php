<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::include('html.form.input', 'input');
        Blade::include('html.form.select', 'select');
        Blade::include('html.form.textarea', 'textarea');
        Blade::include('html.form.checkbox', 'checkbox');
        Blade::include('html.form.file', 'file');
        Blade::include('html.form.submit', 'submit');
        Blade::include('html.form.cancel', 'cancel');
        Blade::include('html.form.froala', 'froala');
    }
}
