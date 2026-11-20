<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Account;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);

        \Illuminate\Support\Facades\Route::resourceVerbs([
            'create' => 'novo',
            'edit' => 'editar'
        ]);

        view()->composer('*', function ($view) {
            // $empresaDigital só é consultado quando alguma cor realmente precisa do fallback,
            // em vez de a cada boot da aplicação (evita 1 query a mais por request/teste sem view).
            $empresaDigital = null;
            $fallback = function () use (&$empresaDigital) {
                return $empresaDigital ??= Account::find(1);
            };

            if (auth()->user() == true AND auth()->user()->account->principal_color) {
                $principalColor = auth()->user()->account->principal_color;
            } else {
                $principalColor = $fallback()?->principal_color;
            }
                        if (auth()->user() == true AND auth()->user()->account->complementary_color) {
                $complementaryColor = auth()->user()->account->complementary_color;
            } else {
                $complementaryColor = $fallback()?->complementary_color;
            }

            if (auth()->user() == true AND auth()->user()->account->opposite_color) {
                $oppositeColor = auth()->user()->account->opposite_color;
            } else {
                $oppositeColor = $fallback()?->opposite_color;
            }

            $view->with([
                'principalColor' => $principalColor,
                'complementaryColor' => $complementaryColor,
                'oppositeColor' => $oppositeColor,
                    ]);
        });

        Paginator::useBootstrap();
    }

}
