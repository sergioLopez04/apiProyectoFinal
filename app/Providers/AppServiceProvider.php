<?php
/*
namespace App\Providers;

use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\ServiceProvider;
use Route;

class AppServiceProvider extends ServiceProvider
{
   
    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        $this->app->resolving(VerifyCsrfToken::class, function (VerifyCsrfToken $csrf) {
            $csrf->except([
                'proyectos',
                'proyectos/*',
                'usuarios',
                'usuarios/*',
            ]);
        });
    }
}*/
