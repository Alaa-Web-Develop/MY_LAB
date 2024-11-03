<?php

use App\Http\Controllers\AdminDashboard\CitiesContrller;
use App\Http\Controllers\AdminDashboard\CourierCollectedTestController;
use App\Http\Controllers\AdminDashboard\CourierController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboard\LabsController;
use App\Http\Controllers\AdminDashboard\TestsController;
use App\Http\Controllers\AdminDashboard\UsersController;
use App\Http\Controllers\AdminDashboard\TumorsController;
use App\Http\Controllers\AdminDashboard\DoctorsController;
use App\Http\Controllers\AdminDashboard\LabTrackController;
use App\Http\Controllers\AdminDashboard\PatientsController;
use App\Http\Controllers\AdminDashboard\DashboardController;
use App\Http\Controllers\AdminDashboard\DiagnosesController;
use App\Http\Controllers\AdminDashboard\LabOrdersController;
use App\Http\Controllers\AdminDashboard\LabBranchesController;
use App\Http\Controllers\AdminDashboard\DoctorImagesController;
use App\Http\Controllers\AdminDashboard\InstitutionsController;
use App\Http\Controllers\AdminDashboard\LabBrancheTestsController;
use App\Http\Controllers\AdminDashboard\LabUsersController;
use App\Http\Controllers\AdminDashboard\PointsController;
use App\Http\Controllers\AdminDashboard\SpecialitiesController;
use App\Http\Controllers\AdminDashboard\SponsoredTestRequestsController;
use App\Http\Controllers\AdminDashboard\SponsoredTestsController;
use App\Http\Controllers\AdminDashboard\SponsorsController;
use App\Http\Controllers\CourierTracking\CourierTrackingController;
use App\Models\CourierCollectedTest;

Route::group([
    'prefix' => 'dashboard',
    'as' => 'dashboard.',
    'middleware' => ['auth']
], function () {

    Route::resource('specialities', SpecialitiesController::class);

    Route::resource('diagnoses', DiagnosesController::class);
    Route::resource('institutions', InstitutionsController::class);
    Route::resource('tumors', TumorsController::class);
    Route::resource('doctors', DoctorsController::class);
    Route::resource('doctor_docs', DoctorImagesController::class);
    Route::get('doctor-docs-download/{id}',[DoctorImagesController::class,'downloadDocs'])->name('download-doc-docs');
    Route::resource('labs', LabsController::class);
    Route::resource('lab_branches', LabBranchesController::class);
    Route::resource('tests', TestsController::class);
    Route::resource('patients', PatientsController::class);
    Route::resource('lab_orders', LabOrdersController::class);
    Route::resource('users', UsersController::class);
    Route::resource('lab_track', LabTrackController::class);
    Route::get('lab-docs-download/{id}',[LabTrackController::class,'downloadResult'])->name('download-lab-docs');
    Route::get('patient-download/{id}',[PatientsController::class,'downloadResult'])->name('download-patient-docs');

    Route::resource('lab_barnch_test', LabBrancheTestsController::class);

    Route::get('/labs/fetch', [LabBrancheTestsController::class, 'getLabs']);
    Route::get('/branches/fetch/{labId}', [LabBrancheTestsController::class, 'getBranches']);
    Route::delete('/tests/{test_id}/branches/{branch_id}', [LabBrancheTestsController::class, 'destroyTestBranche'])->name('tests.branches.destroy');

    Route::put('/update/tests/{test_id}/labs/{lab_id}', [LabBrancheTestsController::class, 'updateTestBranche'])->name('tests.branches.update');

Route::get('/doctors-total-points',[PointsController::class,'index'])->name('total.points.index');
Route::get('/doctors-pointtransfer-requests',[PointsController::class,'getAllPontsTransferRequests'])->name('points.transfer.requests');
Route::post('/doctors-ajax-update-status',[DoctorsController::class,'updateStatus'])->name('doctor.update.status');


Route::get('/labs/{lab}/tests', [LabsController::class,'getTests'])->name('labs.test.info');

Route::post('/update-Transfer-Status', [PointsController::class,'updateTransferStatus'])->name('updateTransferStatus');

Route::get('/labTrack-displaylbOrders',[LabTrackController::class,'index'])->name('track-lab_orders.index');
Route::get('/labTrack-laborder/{id}',[LabTrackController::class,'edit'])->name('track-lab_orders.edit');
Route::put('/labTrack-laborder-update/{id}',[LabTrackController::class,'update'])->name('track-lab_orders.update');

Route::get('mainDashboard/',[DashboardController::class,'index'])->name('mainDashboard.index');

Route::get('ActionFilter/',[DashboardController::class,'ActionFilter'])->name('actions.filter');

Route::get('labUsers/',[LabUsersController::class,'index'])->name('labUsers.index');
Route::post('labUsers/',[LabUsersController::class,'store'])->name('labUsers.store');
Route::put('labUsers/{id}',[LabUsersController::class,'update'])->name('labUsers.update');

Route::delete('labUsers/{id}',[LabUsersController::class,'destroy'])->name('labUsers.destroy');

Route::put('/lab_branches/updateStatus/{id}', [LabBranchesController::class, 'updateStatus'])->name('lab_branches.updateStatus');

Route::resource('/couriers', CourierController::class);
Route::resource('/sponsors',SponsorsController::class);
Route::resource('/sponsored-tests',SponsoredTestsController::class);
Route::resource('/doctors-sponsored-requests',SponsoredTestRequestsController::class);
Route::resource('/couriercollectedtests',CourierCollectedTestController::class);
Route::resource('/courierTracking',CourierTrackingController::class);
Route::get('/display-govs-cities',[CitiesContrller::class,'index'])->name('index-govs-cities');
Route::post('/governorates/store', [CitiesContrller::class, 'storeGovernorate'])->name('governorates.store');
Route::post('/cities/store', [CitiesContrller::class, 'storeCity'])->name('cities.store');


// GET|HEAD        dashboard/courierTracking dashboard.courierTracking.index › CourierTracking\CourierTracki…  
// POST            dashboard/courierTracking dashboard.courierTracking.store › CourierTracking\CourierTracki…  
// GET|HEAD        dashboard/courierTracking/create dashboard.courierTracking.create › CourierTracking\Couri…  
// GET|HEAD        dashboard/courierTracking/{courierTracking} dashboard.courierTracking.show › CourierTrack…  
// PUT|PATCH       dashboard/courierTracking/{courierTracking} dashboard.courierTracking.update › CourierTra…  
// DELETE          dashboard/courierTracking/{courierTracking} dashboard.courierTracking.destroy › CourierTr…  
// GET|HEAD        dashboard/courierTracking/{courierTracking}/edit dashboard.courierTracking.edit › Courier…  

// GET|HEAD        dashboard/couriercollectedtests ............ dashboard.couriercollectedtests.index › App\Models\CourierCollectedTest@index  
//   POST            dashboard/couriercollectedtests ............ dashboard.couriercollectedtests.store › App\Models\CourierCollectedTest@store  
//   GET|HEAD        dashboard/couriercollectedtests/create ... dashboard.couriercollectedtests.create › App\Models\CourierCollectedTest@create  
//   GET|HEAD        dashboard/couriercollectedtests/{couriercollectedtest} dashboard.couriercollectedtests.show › App\Models\CourierCollected…  
//   PUT|PATCH       dashboard/couriercollectedtests/{couriercollectedtest} dashboard.couriercollectedtests.update › App\Models\CourierCollect…
//   DELETE          dashboard/couriercollectedtests/{couriercollectedtest} dashboard.couriercollectedtests.destroy › App\Models\CourierCollec…  
//   GET|HEAD        dashboard/couriercollectedtests/{couriercollectedtest}/edit dashboard.couriercollectedtests.edit › App\Models\CourierColl… 

// GET|HEAD        dashboard/doctors-sponsored-requests dashboard.doctors-sponsored-requests.index …
// POST            dashboard/doctors-sponsored-requests dashboard.doctors-sponsored-requests.store …  
// GET|HEAD        dashboard/doctors-sponsored-requests/create dashboard.doctors-sponsored-requests…  
// GET|HEAD        dashboard/doctors-sponsored-requests/{doctors_sponsored_request} dashboard.docto…  
// PUT|PATCH       dashboard/doctors-sponsored-requests/{doctors_sponsored_request} dashboard.docto…  
// DELETE          dashboard/doctors-sponsored-requests/{doctors_sponsored_request} dashboard.docto…  
// GET|HEAD        dashboard/doctors-sponsored-requests/{doctors_sponsored_request}/edit dashboard.…  

// GET|HEAD        dashboard/sponsors ............ dashboard.sponsors.index › AdminDashboard\SponsorsController@index  
//   POST            dashboard/sponsors ............ dashboard.sponsors.store › AdminDashboard\SponsorsController@store  
//   GET|HEAD        dashboard/sponsors/create ... dashboard.sponsors.create › AdminDashboard\SponsorsController@create  
//   GET|HEAD        dashboard/sponsors/{sponsor} .... dashboard.sponsors.show › AdminDashboard\SponsorsController@show  
//   PUT|PATCH       dashboard/sponsors/{sponsor} dashboard.sponsors.update › AdminDashboard\SponsorsController@update   
//   DELETE          dashboard/sponsors/{sponsor} dashboard.sponsors.destroy › AdminDashboard\SponsorsController@destr…  
//   GET|HEAD        dashboard/sponsors/{sponsor}/edit dashboard.sponsors.edit › AdminDashboard\SponsorsController@edit

// GET|HEAD        dashboard/sponsored-tests dashboard.sponsored-tests.index › AdminDashboard\SponsoredTest…  
// POST            dashboard/sponsored-tests dashboard.sponsored-tests.store › AdminDashboard\SponsoredTest…  
// GET|HEAD        dashboard/sponsored-tests/create dashboard.sponsored-tests.create › AdminDashboard\Spons…  
// GET|HEAD        dashboard/sponsored-tests/{sponsored_test} dashboard.sponsored-tests.show › AdminDashboa…  
// PUT|PATCH       dashboard/sponsored-tests/{sponsored_test} dashboard.sponsored-tests.update › AdminDashb…  
// DELETE          dashboard/sponsored-tests/{sponsored_test} dashboard.sponsored-tests.destroy › AdminDash…  
// GET|HEAD        dashboard/sponsored-tests/{sponsored_test}/edit dashboard.sponsored-tests.edit › AdminDa…  

// dashboard/couriers ................................................. dashboard.couriers.index › AdminDashboard\CourierController@index  
//   POST            dashboard/couriers ................................................. dashboard.couriers.store › AdminDashboard\CourierController@store  
//   GET|HEAD        dashboard/couriers/create ........................................ dashboard.couriers.create › AdminDashboard\CourierController@create  
//   GET|HEAD        dashboard/couriers/{courier} ......................................... dashboard.couriers.show › AdminDashboard\CourierController@show  
//   PUT|PATCH       dashboard/couriers/{courier} ..................................... dashboard.couriers.update › AdminDashboard\CourierController@update  
//   DELETE          dashboard/couriers/{courier} ................................... dashboard.couriers.destroy › AdminDashboard\CourierController@destroy  
//   GET|HEAD        dashboard/couriers/{courier}/edit .................................... dashboard.couriers.edit › AdminDashboard\CourierController@edit 

    // GET|HEAD        dashboard/lab_barnch_test dashboard.lab_barnch_test.index › AdminDashboard\La…  
    // POST            dashboard/lab_barnch_test dashboard.lab_barnch_test.store › AdminDashboard\La…  
    // GET|HEAD        dashboard/lab_barnch_test/create dashboard.lab_barnch_test.create › AdminDash…
    // GET|HEAD        dashboard/lab_barnch_test/{lab_barnch_test} dashboard.lab_barnch_test.show › …  
    // PUT|PATCH       dashboard/lab_barnch_test/{lab_barnch_test} dashboard.lab_barnch_test.update …  
    // DELETE          dashboard/lab_barnch_test/{lab_barnch_test} dashboard.lab_barnch_test.destroy…  
    // GET|HEAD        dashboard/lab_barnch_test/{lab_barnch_test}/edit dashboard.lab_barnch_test.ed…  


    // Route::resource('lab_users',LabUser::class);
    // Route::resource('doctor_users',SpecialitiesController::class);



});
//  GET|HEAD          dashboard/lab_track ................................................................ dashboard.lab_track.index › AdminDashboard\LabTrackController@index  
//   POST            dashboard/lab_track ................................................................ dashboard.lab_track.store › AdminDashboard\LabTrackController@store  
//   GET|HEAD        dashboard/lab_track/create ....................................................... dashboard.lab_track.create › AdminDashboard\LabTrackController@create  
//   GET|HEAD        dashboard/lab_track/{lab_track} ...................................................... dashboard.lab_track.show › AdminDashboard\LabTrackController@show  
//   PUT|PATCH       dashboard/lab_track/{lab_track} .................................................. dashboard.lab_track.update › AdminDashboard\LabTrackController@update  
//   DELETE          dashboard/lab_track/{lab_track} ................................................ dashboard.lab_track.destroy › AdminDashboard\LabTrackController@destroy  
//   GET|HEAD        dashboard/lab_track/{lab_track}/edit ................................................. dashboard.lab_track.edit › AdminDashboard\LabTrackController@edit
// GET|HEAD        / .................................................................................................................. 
// POST            _ignition/execute-solution ........... ignition.executeSolution › Spatie\LaravelIgnition › ExecuteSolutionController
// GET|HEAD        _ignition/health-check ....................... ignition.healthCheck › Spatie\LaravelIgnition › HealthCheckController
// POST            _ignition/update-config .................... ignition.updateConfig › Spatie\LaravelIgnition › UpdateConfigController
// GET|HEAD        api/cities .............................................................. cities.index › Apis\CitiesController@index
// POST            api/cities .............................................................. cities.store › Apis\CitiesController@store
// GET|HEAD        api/cities/{city} ......................................................... cities.show › Apis\CitiesController@show
// PUT|PATCH       api/cities/{city} ..................................................... cities.update › Apis\CitiesController@update
// DELETE          api/cities/{city} ................................................... cities.destroy › Apis\CitiesController@destroy
// GET|HEAD        api/diagnoses ..................................................... diagnoses.index › Apis\DiagnosesController@index
// POST            api/diagnoses ..................................................... diagnoses.store › Apis\DiagnosesController@store
// GET|HEAD        api/diagnoses/{diagnosis} ........................................... diagnoses.show › Apis\DiagnosesController@show
// PUT|PATCH       api/diagnoses/{diagnosis} ....................................... diagnoses.update › Apis\DiagnosesController@update
// DELETE          api/diagnoses/{diagnosis} ..................................... diagnoses.destroy › Apis\DiagnosesController@destroy
// GET|HEAD        api/doctors ........................................................... doctors.index › Apis\DoctorsController@index
// POST            api/doctors ........................................................... doctors.store › Apis\DoctorsController@store  
// GET|HEAD        api/doctors/{doctor} .................................................... doctors.show › Apis\DoctorsController@show  
// PUT|PATCH       api/doctors/{doctor} ................................................ doctors.update › Apis\DoctorsController@update  
// DELETE          api/doctors/{doctor} .............................................. doctors.destroy › Apis\DoctorsController@destroy  
// GET|HEAD        api/governorates ............................................ governorates.index › Apis\GovernoratesController@index  
// POST            api/governorates ............................................ governorates.store › Apis\GovernoratesController@store  
// GET|HEAD        api/governorates/{governorate} ................................ governorates.show › Apis\GovernoratesController@show  
// PUT|PATCH       api/governorates/{governorate} ............................ governorates.update › Apis\GovernoratesController@update  
// DELETE          api/governorates/{governorate} .......................... governorates.destroy › Apis\GovernoratesController@destroy  
// GET|HEAD        api/labOrders ..................................................... labOrders.index › Apis\LabOrdersController@index  
// POST            api/labOrders ..................................................... labOrders.store › Apis\LabOrdersController@store  
// GET|HEAD        api/labOrders/{labOrder} ............................................ labOrders.show › Apis\LabOrdersController@show  
// PUT|PATCH       api/labOrders/{labOrder} ........................................ labOrders.update › Apis\LabOrdersController@update  
// DELETE          api/labOrders/{labOrder} ...................................... labOrders.destroy › Apis\LabOrdersController@destroy  
// GET|HEAD        api/labOrdersTracking ............................. labOrdersTracking.index › Apis\LabOrdersTrackingController@index  
// POST            api/labOrdersTracking ............................. labOrdersTracking.store › Apis\LabOrdersTrackingController@store  
// GET|HEAD        api/labOrdersTracking/{labOrdersTracking} ........... labOrdersTracking.show › Apis\LabOrdersTrackingController@show  
// PUT|PATCH       api/labOrdersTracking/{labOrdersTracking} ....... labOrdersTracking.update › Apis\LabOrdersTrackingController@update  
// DELETE          api/labOrdersTracking/{labOrdersTracking} ..... labOrdersTracking.destroy › Apis\LabOrdersTrackingController@destroy  
// GET|HEAD        api/labs .................................................................... labs.index › Apis\LabsController@index  
// POST            api/labs .................................................................... labs.store › Apis\LabsController@store  
// GET|HEAD        api/labs/{lab} ................................................................ labs.show › Apis\LabsController@show  
// PUT|PATCH       api/labs/{lab} ............................................................ labs.update › Apis\LabsController@update  
// DELETE          api/labs/{lab} .......................................................... labs.destroy › Apis\LabsController@destroy  
// GET|HEAD        api/labsBranches ............................................ labsBranches.index › Apis\LabsBranchesController@index  
// POST            api/labsBranches ............................................ labsBranches.store › Apis\LabsBranchesController@store  
// GET|HEAD        api/labsBranches/{labsBranch} ................................. labsBranches.show › Apis\LabsBranchesController@show  
// PUT|PATCH       api/labsBranches/{labsBranch} ............................. labsBranches.update › Apis\LabsBranchesController@update  
// DELETE          api/labsBranches/{labsBranch} ........................... labsBranches.destroy › Apis\LabsBranchesController@destroy  
// GET|HEAD        api/patients ........................................................ patients.index › Apis\PatientsController@index  
// POST            api/patients ........................................................ patients.store › Apis\PatientsController@store  
// GET|HEAD        api/patients/{patient} ................................................ patients.show › Apis\PatientsController@show  
// PUT|PATCH       api/patients/{patient} ............................................ patients.update › Apis\PatientsController@update  
// DELETE          api/patients/{patient} .......................................... patients.destroy › Apis\PatientsController@destroy  
// GET|HEAD        api/specalities ................................................... specalities.index › Apis\DoctorsController@index  
// POST            api/specalities ................................................... specalities.store › Apis\DoctorsController@store  
// GET|HEAD        api/specalities/{specality} ......................................... specalities.show › Apis\DoctorsController@show  
// PUT|PATCH       api/specalities/{specality} ..................................... specalities.update › Apis\DoctorsController@update  
// DELETE          api/specalities/{specality} ................................... specalities.destroy › Apis\DoctorsController@destroy  
// GET|HEAD        api/tests ................................................................. tests.index › Apis\TestsController@index  
// POST            api/tests ................................................................. tests.store › Apis\TestsController@store  
// GET|HEAD        api/tests/{test} ............................................................ tests.show › Apis\TestsController@show  
// PUT|PATCH       api/tests/{test} ........................................................ tests.update › Apis\TestsController@update  
// DELETE          api/tests/{test} ...................................................... tests.destroy › Apis\TestsController@destroy  
// GET|HEAD        api/tuomrs .............................................................. tuomrs.index › Apis\TuomrsController@index  
// POST            api/tuomrs .............................................................. tuomrs.store › Apis\TuomrsController@store  
// GET|HEAD        api/tuomrs/{tuomr} ........................................................ tuomrs.show › Apis\TuomrsController@show  
// PUT|PATCH       api/tuomrs/{tuomr} .................................................... tuomrs.update › Apis\TuomrsController@update  
// DELETE          api/tuomrs/{tuomr} .................................................. tuomrs.destroy › Apis\TuomrsController@destroy
// GET|HEAD        api/user ...........................................................................................................  
// GET|HEAD        confirm-password ........................................ password.confirm › Auth\ConfirmablePasswordController@show  
// POST            confirm-password .......................................................... Auth\ConfirmablePasswordController@store  
// GET|HEAD        dashboard ........................................................................................... dashboard.home  
// GET|HEAD        dashboard/diagnoses ........................... dashboard.diagnoses.index › AdminDashboard\DiagnosesController@index  
// POST            dashboard/diagnoses ........................... dashboard.diagnoses.store › AdminDashboard\DiagnosesController@store  
// GET|HEAD        dashboard/diagnoses/create .................. dashboard.diagnoses.create › AdminDashboard\DiagnosesController@create  
// GET|HEAD        dashboard/diagnoses/{diagnosis} ................. dashboard.diagnoses.show › AdminDashboard\DiagnosesController@show  
// PUT|PATCH       dashboard/diagnoses/{diagnosis} ............. dashboard.diagnoses.update › AdminDashboard\DiagnosesController@update  
// DELETE          dashboard/diagnoses/{diagnosis} ........... dashboard.diagnoses.destroy › AdminDashboard\DiagnosesController@destroy  
// GET|HEAD        dashboard/diagnoses/{diagnosis}/edit ............ dashboard.diagnoses.edit › AdminDashboard\DiagnosesController@edit  
// GET|HEAD        dashboard/doctor_docs .................... dashboard.doctor_docs.index › AdminDashboard\DoctorImagesController@index  
// POST            dashboard/doctor_docs .................... dashboard.doctor_docs.store › AdminDashboard\DoctorImagesController@store  
// GET|HEAD        dashboard/doctor_docs/create ........... dashboard.doctor_docs.create › AdminDashboard\DoctorImagesController@create  
// GET|HEAD        dashboard/doctor_docs/{doctor_doc} ......... dashboard.doctor_docs.show › AdminDashboard\DoctorImagesController@show  
// PUT|PATCH       dashboard/doctor_docs/{doctor_doc} ..... dashboard.doctor_docs.update › AdminDashboard\DoctorImagesController@update  
// DELETE          dashboard/doctor_docs/{doctor_doc} ... dashboard.doctor_docs.destroy › AdminDashboard\DoctorImagesController@destroy  
// GET|HEAD        dashboard/doctor_docs/{doctor_doc}/edit .... dashboard.doctor_docs.edit › AdminDashboard\DoctorImagesController@edit  
// GET|HEAD        dashboard/doctors ................................. dashboard.doctors.index › AdminDashboard\DoctorsController@index  
// POST            dashboard/doctors ................................. dashboard.doctors.store › AdminDashboard\DoctorsController@store  
// GET|HEAD        dashboard/doctors/create ........................ dashboard.doctors.create › AdminDashboard\DoctorsController@create  
// GET|HEAD        dashboard/doctors/{doctor} .......................... dashboard.doctors.show › AdminDashboard\DoctorsController@show  
// PUT|PATCH       dashboard/doctors/{doctor} ...................... dashboard.doctors.update › AdminDashboard\DoctorsController@update  
// DELETE          dashboard/doctors/{doctor} .................... dashboard.doctors.destroy › AdminDashboard\DoctorsController@destroy  
// GET|HEAD        dashboard/doctors/{doctor}/edit ..................... dashboard.doctors.edit › AdminDashboard\DoctorsController@edit  
// GET|HEAD        dashboard/institutions .................. dashboard.institutions.index › AdminDashboard\InstitutionsController@index
// POST            dashboard/institutions .................. dashboard.institutions.store › AdminDashboard\InstitutionsController@store  
// GET|HEAD        dashboard/institutions/create ......... dashboard.institutions.create › AdminDashboard\InstitutionsController@create  
// GET|HEAD        dashboard/institutions/{institution} ...... dashboard.institutions.show › AdminDashboard\InstitutionsController@show  
// PUT|PATCH       dashboard/institutions/{institution} .. dashboard.institutions.update › AdminDashboard\InstitutionsController@update  
// DELETE          dashboard/institutions/{institution} dashboard.institutions.destroy › AdminDashboard\InstitutionsController@destroy   
// GET|HEAD        dashboard/institutions/{institution}/edit . dashboard.institutions.edit › AdminDashboard\InstitutionsController@edit  
// GET|HEAD        dashboard/lab_branches ................... dashboard.lab_branches.index › AdminDashboard\LabBranchesController@index  
// POST            dashboard/lab_branches ................... dashboard.lab_branches.store › AdminDashboard\LabBranchesController@store  
// GET|HEAD        dashboard/lab_branches/create .......... dashboard.lab_branches.create › AdminDashboard\LabBranchesController@create  
// GET|HEAD        dashboard/lab_branches/{lab_branch} ........ dashboard.lab_branches.show › AdminDashboard\LabBranchesController@show  
// PUT|PATCH       dashboard/lab_branches/{lab_branch} .... dashboard.lab_branches.update › AdminDashboard\LabBranchesController@update  
// DELETE          dashboard/lab_branches/{lab_branch} .. dashboard.lab_branches.destroy › AdminDashboard\LabBranchesController@destroy  
// GET|HEAD        dashboard/lab_branches/{lab_branch}/edit ... dashboard.lab_branches.edit › AdminDashboard\LabBranchesController@edit  
// GET|HEAD        dashboard/lab_orders ......................... dashboard.lab_orders.index › AdminDashboard\LabOrdersController@index  
// POST            dashboard/lab_orders ......................... dashboard.lab_orders.store › AdminDashboard\LabOrdersController@store  
// GET|HEAD        dashboard/lab_orders/create ................ dashboard.lab_orders.create › AdminDashboard\LabOrdersController@create  
// GET|HEAD        dashboard/lab_orders/{lab_order} ............... dashboard.lab_orders.show › AdminDashboard\LabOrdersController@show  
// PUT|PATCH       dashboard/lab_orders/{lab_order} ........... dashboard.lab_orders.update › AdminDashboard\LabOrdersController@update  
// DELETE          dashboard/lab_orders/{lab_order} ......... dashboard.lab_orders.destroy › AdminDashboard\LabOrdersController@destroy  
// GET|HEAD        dashboard/lab_orders/{lab_order}/edit .......... dashboard.lab_orders.edit › AdminDashboard\LabOrdersController@edit  
// GET|HEAD        dashboard/labs .......................................... dashboard.labs.index › AdminDashboard\LabsController@index  
// POST            dashboard/labs .......................................... dashboard.labs.store › AdminDashboard\LabsController@store  
// GET|HEAD        dashboard/labs/create ................................. dashboard.labs.create › AdminDashboard\LabsController@create  
// GET|HEAD        dashboard/labs/{lab} ...................................... dashboard.labs.show › AdminDashboard\LabsController@show  
// PUT|PATCH       dashboard/labs/{lab} .................................. dashboard.labs.update › AdminDashboard\LabsController@update  
// DELETE          dashboard/labs/{lab} ................................ dashboard.labs.destroy › AdminDashboard\LabsController@destroy  
// GET|HEAD        dashboard/labs/{lab}/edit ................................. dashboard.labs.edit › AdminDashboard\LabsController@edit  
// GET|HEAD        dashboard/patients .............................. dashboard.patients.index › AdminDashboard\PatientsController@index  
// POST            dashboard/patients .............................. dashboard.patients.store › AdminDashboard\PatientsController@store  
// GET|HEAD        dashboard/patients/create ..................... dashboard.patients.create › AdminDashboard\PatientsController@create  
// GET|HEAD        dashboard/patients/{patient} ...................... dashboard.patients.show › AdminDashboard\PatientsController@show  
// PUT|PATCH       dashboard/patients/{patient} .................. dashboard.patients.update › AdminDashboard\PatientsController@update  
// DELETE          dashboard/patients/{patient} ................ dashboard.patients.destroy › AdminDashboard\PatientsController@destroy  
// GET|HEAD        dashboard/patients/{patient}/edit ................. dashboard.patients.edit › AdminDashboard\PatientsController@edit
// GET|HEAD        dashboard/specialities .................. dashboard.specialities.index › AdminDashboard\SpecialitiesController@index  
// POST            dashboard/specialities .................. dashboard.specialities.store › AdminDashboard\SpecialitiesController@store  
// GET|HEAD        dashboard/specialities/create ......... dashboard.specialities.create › AdminDashboard\SpecialitiesController@create  
// GET|HEAD        dashboard/specialities/{speciality} ....... dashboard.specialities.show › AdminDashboard\SpecialitiesController@show  
// PUT|PATCH       dashboard/specialities/{speciality} ... dashboard.specialities.update › AdminDashboard\SpecialitiesController@update  
// DELETE          dashboard/specialities/{speciality} . dashboard.specialities.destroy › AdminDashboard\SpecialitiesController@destroy  
// GET|HEAD        dashboard/specialities/{speciality}/edit .. dashboard.specialities.edit › AdminDashboard\SpecialitiesController@edit  
// GET|HEAD        dashboard/tests ....................................... dashboard.tests.index › AdminDashboard\TestsController@index  
// POST            dashboard/tests ....................................... dashboard.tests.store › AdminDashboard\TestsController@store  
// GET|HEAD        dashboard/tests/create .............................. dashboard.tests.create › AdminDashboard\TestsController@create  
// GET|HEAD        dashboard/tests/{test} .................................. dashboard.tests.show › AdminDashboard\TestsController@show  
// PUT|PATCH       dashboard/tests/{test} .............................. dashboard.tests.update › AdminDashboard\TestsController@update  
// DELETE          dashboard/tests/{test} ............................ dashboard.tests.destroy › AdminDashboard\TestsController@destroy  
// GET|HEAD        dashboard/tests/{test}/edit ............................. dashboard.tests.edit › AdminDashboard\TestsController@edit  
// GET|HEAD        dashboard/tumors .................................... dashboard.tumors.index › AdminDashboard\TumorsController@index  
// POST            dashboard/tumors .................................... dashboard.tumors.store › AdminDashboard\TumorsController@store  
// GET|HEAD        dashboard/tumors/create ........................... dashboard.tumors.create › AdminDashboard\TumorsController@create  
// GET|HEAD        dashboard/tumors/{tumor} .............................. dashboard.tumors.show › AdminDashboard\TumorsController@show  
// PUT|PATCH       dashboard/tumors/{tumor} .......................... dashboard.tumors.update › AdminDashboard\TumorsController@update  
// DELETE          dashboard/tumors/{tumor} ........................ dashboard.tumors.destroy › AdminDashboard\TumorsController@destroy  
// GET|HEAD        dashboard/tumors/{tumor}/edit ......................... dashboard.tumors.edit › AdminDashboard\TumorsController@edit  
// GET|HEAD        dashboard/users ....................................... dashboard.users.index › AdminDashboard\UsersController@index  
// POST            dashboard/users ....................................... dashboard.users.store › AdminDashboard\UsersController@store  
// GET|HEAD        dashboard/users/create .............................. dashboard.users.create › AdminDashboard\UsersController@create  
// GET|HEAD        dashboard/users/{user} .................................. dashboard.users.show › AdminDashboard\UsersController@show  
// PUT|PATCH       dashboard/users/{user} .............................. dashboard.users.update › AdminDashboard\UsersController@update  
// DELETE          dashboard/users/{user} ............................ dashboard.users.destroy › AdminDashboard\UsersController@destroy  
// GET|HEAD        dashboard/users/{user}/edit ............................. dashboard.users.edit › AdminDashboard\UsersController@edit  
// GET|HEAD        doctor/dashboard ...................................... doctor.download-app › AdminDashboard\DoctorDownloadApp@index  
// POST            email/verification-notification ............. verification.send › Auth\EmailVerificationNotificationController@store  
// GET|HEAD        forgot-password ......................................... password.request › Auth\PasswordResetLinkController@create
// POST            forgot-password ............................................ password.email › Auth\PasswordResetLinkController@store  
// GET|HEAD        lab .......................................................... labTrack.index › LabTracking\LabTrackController@index  
// POST            lab .......................................................... labTrack.store › LabTracking\LabTrackController@store  
// GET|HEAD        lab/create ................................................. labTrack.create › LabTracking\LabTrackController@create  
// GET|HEAD        lab/{} ......................................................... labTrack.show › LabTracking\LabTrackController@show  
// PUT|PATCH       lab/{} ..................................................... labTrack.update › LabTracking\LabTrackController@update  
// DELETE          lab/{} ................................................... labTrack.destroy › LabTracking\LabTrackController@destroy  
// GET|HEAD        lab/{}/edit .................................................... labTrack.edit › LabTracking\LabTrackController@edit  
// GET|HEAD        login ........................................................... login › Auth\AuthenticatedSessionController@create  
// POST            login .................................................................... Auth\AuthenticatedSessionController@store  
// POST            logout ........................................................ logout › Auth\AuthenticatedSessionController@destroy  
// PUT             password .......................................................... password.update › Auth\PasswordController@update  
// GET|HEAD        register ........................................................... register › Auth\RegisteredUserController@create  
// POST            register ....................................................................... Auth\RegisteredUserController@store  
// POST            reset-password ................................................... password.store › Auth\NewPasswordController@store  
// GET|HEAD        reset-password/{token} .......................................... password.reset › Auth\NewPasswordController@create  
// GET|HEAD        sanctum/csrf-cookie .............................. sanctum.csrf-cookie › Laravel\Sanctum › CsrfCookieController@show  
// GET|HEAD        two-factor-challenge ........... two-factor.login › Laravel\Fortify › TwoFactorAuthenticatedSessionController@create  
// POST            two-factor-challenge ............................... Laravel\Fortify › TwoFactorAuthenticatedSessionController@store  
// GET|HEAD        user/confirm-password ......................................... Laravel\Fortify › ConfirmablePasswordController@show  
// POST            user/confirm-password ..................... password.confirm › Laravel\Fortify › ConfirmablePasswordController@store  
// GET|HEAD        user/confirmed-password-status .... password.confirmation › Laravel\Fortify › ConfirmedPasswordStatusController@show  
// POST            user/confirmed-two-factor-authentication two-factor.confirm › Laravel\Fortify › ConfirmedTwoFactorAuthenticationCon…  
// PUT             user/password ................................... user-password.update › Laravel\Fortify › PasswordController@update  
// PUT             user/profile-information ... user-profile-information.update › Laravel\Fortify › ProfileInformationController@update  
// POST            user/two-factor-authentication ....... two-factor.enable › Laravel\Fortify › TwoFactorAuthenticationController@store  
// DELETE          user/two-factor-authentication .... two-factor.disable › Laravel\Fortify › TwoFactorAuthenticationController@destroy  
// GET|HEAD        user/two-factor-qr-code ...................... two-factor.qr-code › Laravel\Fortify › TwoFactorQrCodeController@show  
// GET|HEAD        user/two-factor-recovery-codes .......... two-factor.recovery-codes › Laravel\Fortify › RecoveryCodeController@index  
// POST            user/two-factor-recovery-codes ...................................... Laravel\Fortify › RecoveryCodeController@store  
// GET|HEAD        user/two-factor-secret-key ............. two-factor.secret-key › Laravel\Fortify › TwoFactorSecretKeyController@show  
// GET|HEAD        verify-email .......................................... verification.notice › Auth\EmailVerificationPromptController  
// GET|HEAD        verify-email/{id}/{hash} .......................................... verification.verify › Auth\VerifyEmailController  