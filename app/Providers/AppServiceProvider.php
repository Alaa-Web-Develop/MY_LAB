<?php

namespace App\Providers;

use App\Channels\SmsChannel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Resources\Json\JsonResource;

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
      

        Notification::extend('sms', function ($app) {
            return new SmsChannel();
        });
        
           // Check if the request URI is `/`
    Route::get('/', function () {
        return Redirect::to('/admin');
    });
        JsonResource::withoutWrapping();
    }
}
