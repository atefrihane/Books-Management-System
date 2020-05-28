<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $models = [
            'User',
            'Book',
            'Article',
            'Category',
            'Language',
            'Author',
            'Image', 'Statistic', 'Role', //Just a class

        ];
        foreach ($models as $model) {
            $this->app->bind(
                "App\Contracts\\{$model}RepositoryInterface",
                "App\Repositories\\{$model}Repository"
            );
        }

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
