<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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

     //모든 뷰에서 데이터를 공유할 필요가 있을경우 share()를 이용한다.
    public function boot()
    {
        View::share('name', 'jongin');
    }
}
