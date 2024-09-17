<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LabTracking\LabTrackController;

Route::group([
    'prefix' => 'lab',
    'middleware' => ['auth','is-lab'],
    'as' => 'labTrack.',
], function () {

            Route::resource('/', LabTrackController::class);
            // Route::post('test-upload/{id}',[LabTrackController::class,'testupload'])->name('upload-test-result');

            Route::get('branch-docs-download/{id}',[LabTrackController::class,'downloadResult'])->name('download-lab-docs');

            Route::get('edit-laborder/{id}',[LabTrackController::class,'edit'])->name('edit-laborder-track');

            Route::put('update-laborder/{id}',[LabTrackController::class,'update'])->name('update-laborder-track');

 
});


//   GET|HEAD        lab ................. labTrack.index › LabTracking\LabTrackController@index  
//   POST            lab ................. labTrack.store › LabTracking\LabTrackController@store  
//   GET|HEAD        lab/create .......... labTrack.create › LabTracking\LabTrackController@create  
//   GET|HEAD        lab/{} ...............labTrack.show › LabTracking\LabTrackController@show  
//   PUT|PATCH       lab/{} ...............labTrack.update › LabTracking\LabTrackController@update  
//   DELETE          lab/{} ...............labTrack.destroy › LabTracking\LabTrackController@destroy  
//   GET|HEAD        lab/{}/edit ..........labTrack.edit › LabTracking\LabTrackController@edit 