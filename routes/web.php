<?php

use App\Http\Controllers\AdminDashboard\CitiesContrller;
use App\Http\Controllers\AdminDashboard\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//   return redirect('/');
// });

Route::get('/admin', function () {
  return redirect()->route('dashboard.home');
});

Route::get('/main', function () {
  if (Auth::check()) {
    if (Auth::user()->type == 'admin') {
      return redirect()->route('dashboard.mainDashboard.index');
    } elseif (Auth::user()->type == 'doctor') {
      return view('downloadMobileApp.index');
     }elseif (Auth::user()->type == 'lab'){
       return redirect()->route('labTrack.index');
   }

  }
})->middleware(['auth'])->name('dashboard.home');

//ajax get cities
Route::get('/cities/{governId}',[CitiesContrller::class,'getCitiesByGovernId'])->name('cities-ajax');

require __DIR__.'/auth.php';
require __DIR__ . '/dashboard.php';
require __DIR__ . '/lab.php';
require __DIR__ . '/doctor.php';





// GET|HEAD        two-factor-challenge two-factor.login › Laravel\Fortify › TwoFactorAuthenticatedSessionContr…  
// POST            two-factor-challenge ........ Laravel\Fortify › TwoFactorAuthenticatedSessionController@store  
// GET|HEAD        user/confirm-password .................. Laravel\Fortify › ConfirmablePasswordController@show  
// POST            user/confirm-password password.confirm › Laravel\Fortify › ConfirmablePasswordController@sto…  
// GET|HEAD        user/confirmed-password-status password.confirmation › Laravel\Fortify › ConfirmedPasswordSt…  
// POST            user/confirmed-two-factor-authentication two-factor.confirm › Laravel\Fortify › ConfirmedTwo…  
// PUT             user/password ............ user-password.update › Laravel\Fortify › PasswordController@update  
// PUT             user/profile-information user-profile-information.update › Laravel\Fortify › ProfileInformat…  
// POST            user/two-factor-authentication two-factor.enable › Laravel\Fortify › TwoFactorAuthentication…  
// DELETE          user/two-factor-authentication two-factor.disable › Laravel\Fortify › TwoFactorAuthenticatio…
// GET|HEAD        user/two-factor-qr-code two-factor.qr-code › Laravel\Fortify › TwoFactorQrCodeController@show  
// GET|HEAD        user/two-factor-recovery-codes two-factor.recovery-codes › Laravel\Fortify › RecoveryCodeCon…  
// POST            user/two-factor-recovery-codes ............... Laravel\Fortify › RecoveryCodeController@store  
// GET|HEAD        user/two-factor-secret-key two-factor.secret-key › Laravel\Fortify › TwoFactorSecretKeyContr… 