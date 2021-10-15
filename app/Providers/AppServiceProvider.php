<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Account;

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

        $empresaDigital = Account::find(1);

        view()->composer('*', function ($view) use($empresaDigital) {
            if (auth()->user() == true AND auth()->user()->account->principal_color) {
                $principalColor = auth()->user()->account->principal_color;
            } else {
                $principalColor = $empresaDigital->principal_color;
            }
                        if (auth()->user() == true AND auth()->user()->account->complementary_color) {
                $complementaryColor = auth()->user()->account->complementary_color;
            } else {
                $complementaryColor = $empresaDigital->complementary_color;
            }

            if (auth()->user() == true AND auth()->user()->account->opposite_color) {
                $oppositeColor = auth()->user()->account->opposite_color;
            } else {
                $oppositeColor = $empresaDigital->opposite_color;
            }

            $view->with([
                'principalColor' => $principalColor,
                'complementaryColor' => $complementaryColor,
                'oppositeColor' => $oppositeColor,
                    ]);
        });
    }

}
