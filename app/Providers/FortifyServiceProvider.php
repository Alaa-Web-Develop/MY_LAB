<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $request = request();
        if ($request->is('dashboard/*')) {
            Config::set('fortify.guard', 'web');
            Config::set('fortify.prefix', 'admin');
        }
        if ($request->is('lab/*')) {
            Config::set('fortify.guard', 'lab');
            Config::set('fortify.prefix', 'lab');
            Config::set('fortify.passwords', 'labs');
            Config::set('fortify.home','/labTracking');

        }
        if ($request->is('doctor/dashboard/*')) {
            Config::set('fortify.guard', 'doctor');
            Config::set('fortify.prefix', 'doctor');
            Config::set('fortify.passwords', 'doctors');
            Config::set('fortify.home','doctor/dashboard');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        //Fortify views
        // Fortify::loginView('auth.login');
        Fortify::viewPrefix('auth.');
    }
}
