<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboard\DoctorDownloadApp;


Route::group([
    // 'middleware'=>['auth', 'verified','auth-type']
    'middleware'=>['auth','is-doctor'],
    'prefix'=>'doctor/dashboard',
    'as'=>'doctor.'

],function(){
    Route::get('/', [DoctorDownloadApp::class,'index'])->name('download-app');

});


