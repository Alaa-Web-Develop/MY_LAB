<?php

use App\Http\Controllers\Apis\AccessTokensController;
use App\Http\Controllers\Apis\ChangePasswordController;
use App\Http\Controllers\Apis\CitiesController;
use App\Http\Controllers\Apis\DiagnosesController;
use App\Http\Controllers\Apis\DoctorCasesController;
use App\Http\Controllers\Apis\DoctorsController;
use App\Http\Controllers\Apis\ForgetPAsswordApiController;
use App\Http\Controllers\Apis\GovernoratesController;
use App\Http\Controllers\Apis\InstitutionsController;
use App\Http\Controllers\Apis\LabOrdersController;
use App\Http\Controllers\Apis\LabOrdersTrackingController;
use App\Http\Controllers\Apis\LabsBranchesController;
use App\Http\Controllers\Apis\LabsController;
use App\Http\Controllers\Apis\PatientCasesController;
use App\Http\Controllers\Apis\PatientsController;
use App\Http\Controllers\Apis\PointsTransferController;
use App\Http\Controllers\Apis\PointTransactionsController;
use App\Http\Controllers\Apis\SpecalityController;
use App\Http\Controllers\Apis\TestsController;
use App\Http\Controllers\Apis\TuomrsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//doctors
Route::apiResource('/doctors',DoctorsController::class);
// GET|HEAD        api/doctors ..................doctors.index › Apis\DoctorsController@index  
// POST            api/doctors ..................doctors.store › Apis\DoctorsController@store  
// GET|HEAD        api/doctors/{doctor} .........doctors.show › Apis\DoctorsController@show  
// PUT|PATCH       api/doctors/{doctor} .........doctors.update › Apis\DoctorsController@update  
// DELETE          api/doctors/{doctor} ........ doctors.destroy › Apis\DoctorsController@destroy  

//checkPofileStatusByDoctorNumber/{randomNumber}
Route::get('/checkPofileStatusByDoctorNumber/{randomNumber}',[DoctorsController::class,'checkPofileStatusByDoctorNumber']);
//check is_first_Login
Route::get('/first-login',[DoctorsController::class,'checkFirstLogin'])->middleware('auth:sanctum');
 
Route::post('/doctorupdateProfile/{id}',[DoctorsController::class,'update']);




//CitiesController
Route::apiResource('/cities',CitiesController::class);
//   GET|HEAD        api/cities ................................................................ cities.index › Apis\CitiesController@index  
//   POST            api/cities ................................................................ cities.store › Apis\CitiesController@store  
//   GET|HEAD        api/cities/{city} ........................................................... cities.show › Apis\CitiesController@show  
//   PUT|PATCH       api/cities/{city} ....................................................... cities.update › Apis\CitiesController@update  
//   DELETE          api/cities/{city} ..................................................... cities.destroy › Apis\CitiesController@destroy  


//GovernoratesController
Route::apiResource('/governorates',GovernoratesController::class);
//   GET|HEAD        api/governorates .............................................. governorates.index › Apis\GovernoratesController@index  
//   POST            api/governorates .............................................. governorates.store › Apis\GovernoratesController@store  
//   GET|HEAD        api/governorates/{governorate} .................................. governorates.show › Apis\GovernoratesController@show  
//   PUT|PATCH       api/governorates/{governorate} .............................. governorates.update › Apis\GovernoratesController@update  
//   DELETE          api/governorates/{governorate} ............................ governorates.destroy › Apis\GovernoratesController@destroy  


//DiagnosesController
Route::apiResource('/diagnoses',DiagnosesController::class);
//   GET|HEAD        api/diagnoses ....................................................... diagnoses.index › Apis\DiagnosesController@index  
//   POST            api/diagnoses ....................................................... diagnoses.store › Apis\DiagnosesController@store  
//   GET|HEAD        api/diagnoses/{diagnosis} ............................................. diagnoses.show › Apis\DiagnosesController@show  
//   PUT|PATCH       api/diagnoses/{diagnosis} ......................................... diagnoses.update › Apis\DiagnosesController@update  
//   DELETE          api/diagnoses/{diagnosis} ....................................... diagnoses.destroy › Apis\DiagnosesController@destroy  


//SpecalityController
Route::apiResource('/specalities',SpecalityController::class);

//   GET|HEAD        api/specalities ..................................................... specalities.index › Apis\DoctorsController@index
//   POST            api/specalities ..................................................... specalities.store › Apis\DoctorsController@store  
//   GET|HEAD        api/specalities/{specality} ........................................... specalities.show › Apis\DoctorsController@show  
//   PUT|PATCH       api/specalities/{specality} ....................................... specalities.update › Apis\DoctorsController@update  
//   DELETE          api/specalities/{specality} ..................................... specalities.destroy › Apis\DoctorsController@destroy  

Route::get('/institutions',[InstitutionsController::class,'index']);

//TuomrsController
Route::apiResource('/tuomrs',TuomrsController::class)->middleware('auth:sanctum');
//   GET|HEAD        api/tuomrs ................................................................ tuomrs.index › Apis\TuomrsController@index  
//   POST            api/tuomrs ................................................................ tuomrs.store › Apis\TuomrsController@store  
//   GET|HEAD        api/tuomrs/{tuomr} .......................................................... tuomrs.show › Apis\TuomrsController@show  
//   PUT|PATCH       api/tuomrs/{tuomr} ...................................................... tuomrs.update › Apis\TuomrsController@update  
//   DELETE          api/tuomrs/{tuomr} .................................................... tuomrs.destroy › Apis\TuomrsController@destroy  


//TestsController
Route::apiResource('/tests',TestsController::class)->middleware('auth:sanctum');
//   GET|HEAD        api/tests ................................................................... tests.index › Apis\TestsController@index  
//   POST            api/tests ................................................................... tests.store › Apis\TestsController@store  
//   GET|HEAD        api/tests/{test} .............................................................. tests.show › Apis\TestsController@show  
//   PUT|PATCH       api/tests/{test} .......................................................... tests.update › Apis\TestsController@update  
//   DELETE          api/tests/{test} ........................................................ tests.destroy › Apis\TestsController@destroy  
//AvailableTestsInBranch
Route::get('/AvailableTestsInLab/{labId}',[TestsController::class,'AvailableTestsInBranch'])->middleware('auth:sanctum');

//LabsController
Route::apiResource('/labs',LabsController::class)->middleware('auth:sanctum');
//   GET|HEAD        api/labs ...................................................................... labs.index › Apis\LabsController@index  
//   POST            api/labs ...................................................................... labs.store › Apis\LabsController@store  
//   GET|HEAD        api/labs/{lab} .................................................................. labs.show › Apis\LabsController@show  
//   PUT|PATCH       api/labs/{lab} .............................................................. labs.update › Apis\LabsController@update  
//   DELETE          api/labs/{lab} ............................................................ labs.destroy › Apis\LabsController@destroy  


//LabsBranchesController
Route::apiResource('/labsBranches',LabsBranchesController::class)->middleware('auth:sanctum');
Route::get('/GetBranchesByLab_id_Test_id',[LabsBranchesController::class,'GetBranchesByLab_id_Test_id'])->middleware('auth:sanctum');
//   GET|HEAD        api/labsBranches .............................................. labsBranches.index › Apis\LabsBranchesController@index  
//   POST            api/labsBranches .............................................. labsBranches.store › Apis\LabsBranchesController@store  
//   GET|HEAD        api/labsBranches/{labsBranch} ................................... labsBranches.show › Apis\LabsBranchesController@show  
//   PUT|PATCH       api/labsBranches/{labsBranch} ............................... labsBranches.update › Apis\LabsBranchesController@update  
//   DELETE          api/labsBranches/{labsBranch} ............................. labsBranches.destroy › Apis\LabsBranchesController@destroy  


//PatientsController
Route::apiResource('/patients',PatientsController::class)->middleware('auth:sanctum');
//   GET|HEAD        api/patients .......................................................... patients.index › Apis\PatientsController@index  
//   POST            api/patients .......................................................... patients.store › Apis\PatientsController@store  
//   GET|HEAD        api/patients/{patient} .................................................. patients.show › Apis\PatientsController@show  
//   PUT|PATCH       api/patients/{patient} .............................................. patients.update › Apis\PatientsController@update  
//   DELETE          api/patients/{patient} ............................................ patients.destroy › Apis\PatientsController@destroy  


//LabOrdersController
Route::apiResource('/labOrders',LabOrdersController::class)->middleware('auth:sanctum');
//   GET|HEAD        api/labOrders ....................................................... labOrders.index › Apis\LabOrdersController@index  
//   POST            api/labOrders ....................................................... labOrders.store › Apis\LabOrdersController@store  
//   GET|HEAD        api/labOrders/{labOrder} .............................................. labOrders.show › Apis\LabOrdersController@show  
//   PUT|PATCH       api/labOrders/{labOrder} .......................................... labOrders.update › Apis\LabOrdersController@update  
//   DELETE          api/labOrders/{labOrder} ........................................ labOrders.destroy › Apis\LabOrdersController@destroy  


//LabOrdersTrackingController
Route::apiResource('/labOrdersTracking',LabOrdersTrackingController::class)->middleware('auth:sanctum');
//   GET|HEAD        api/labOrdersTracking ............................... labOrdersTracking.index › Apis\LabOrdersTrackingController@index  
//   POST            api/labOrdersTracking ............................... labOrdersTracking.store › Apis\LabOrdersTrackingController@store  
//   GET|HEAD        api/labOrdersTracking/{labOrdersTracking} ............. labOrdersTracking.show › Apis\LabOrdersTrackingController@show  
//   PUT|PATCH       api/labOrdersTracking/{labOrdersTracking} ......... labOrdersTracking.update › Apis\LabOrdersTrackingController@update  
//   DELETE          api/labOrdersTracking/{labOrdersTracking} ....... labOrdersTracking.destroy › Apis\LabOrdersTrackingController@destroy  

Route::apiResource('/patientCases',PatientCasesController::class)->middleware('auth:sanctum');
//   GET|HEAD        api/patientCases ............ patientCases.index › Apis\PatientCasesController@index  
//   POST            api/patientCases ............ patientCases.store › Apis\PatientCasesController@store  
//   GET|HEAD        api/patientCases/{patientCase} patientCases.show › Apis\PatientCasesController@show
//   PUT|PATCH       api/patientCases/{patientCase} patientCases.update › Apis\PatientCasesController@up…  
//   DELETE          api/patientCases/{patientCase} patientCases.destroy › Apis\PatientCasesController@d…  

//Generate token
Route::post('auth/access-tokens',[AccessTokensController::class,'store'])->middleware('guest:sanctum');

Route::delete('auth/access-tokens/{token?}',[AccessTokensController::class,'destroy'])->middleware('auth:sanctum');

Route::delete('auth/access-tokens',[AccessTokensController::class,'revokeAllTokens'])->middleware('auth:sanctum');

//change user password
Route::post('/changePassword',[ChangePasswordController::class,'passwordChange'])->middleware('auth:sanctum');

//Points
Route::get('/get-doctor-points',[PointTransactionsController::class,'GetDoctorPoints'])->middleware('auth:sanctum');

Route::get('/redeem-points',[PointTransactionsController::class,'redeemPoints'])->middleware('auth:sanctum');

//points transfer
Route::post('request-transfer', [PointsTransferController::class, 'requestTransfer'])->middleware('auth:sanctum');
Route::get('check-admin-approved/{id}', [PointsTransferController::class, 'CheckAdminApproval'])->middleware('auth:sanctum');

Route::post('getDiscountValue-ByLabidTestid',[PatientsController::class,'getDiscountValueByLabidTestid'])->middleware('auth:sanctum');    

Route::get('Get-AuthDoctor-Transacions',[PointTransactionsController::class,'GetAuthDoctorTransacions'])->middleware('auth:sanctum');
// Route::get('/send-test-email', function () {
//     $email = 'alaa.webdev@gmail.com'; // Replace with the doctor's email

//     try {
//         Mail::raw('This is a test email.', function ($message) use ($email) {
//             $message->to($email)
//                     ->subject('Test Email');
//         });

//         return 'Email sent successfully!';
//     } catch (\Exception $e) {
//         return 'Failed to send email: ' . $e->getMessage();
//     }
// });

Route::get('/data-by-type', [DoctorsController::class, 'getDataByType'])->middleware('auth:sanctum');

Route::post('/doctor/forgot-password', [ForgetPAsswordApiController::class,'forgotPassword']);
Route::post('/doctor/login', [ForgetPAsswordApiController::class,'login']);
Route::post('/doctor/change-password-for-forget', [ForgetPAsswordApiController::class,'changePasswordForForget'])->middleware('auth:sanctum');

Route::get('/doctor-cases-labOrders',[DoctorCasesController::class,'getDoctorWithPatientsCasesLabOrders'])->middleware('auth:sanctum');

Route::post('/lab-test-has-courier',[LabOrdersController::class,'checkCourierStatus'])->middleware('auth:sanctum');

Route::get('/lab-test-allCouriersWithAreas',[LabOrdersController::class,'getCouriersWithAreas'])->middleware('auth:sanctum');

Route::get('/lab-test-CourierWithAreas/{id}',[LabOrdersController::class,'getCourierWithAreas'])->middleware('auth:sanctum');

