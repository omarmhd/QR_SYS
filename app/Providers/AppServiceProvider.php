<?php

namespace App\Providers;

use App\Services\FcmNotificationService;
use App\Services\FirestoreService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\LocaleEnum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
            Schema::defaultStringLength(191);
                 view()->share('locales',LocaleEnum::cases());

        $this->app->singleton('firestore', function ($app) {
            return new FirestoreService();
        });

        $this->app->singleton('notification', function ($app) {
            return new FcmNotificationService();
        });
    }
}
