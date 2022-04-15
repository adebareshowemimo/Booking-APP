<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\Admin\BookingTypeController as AdminBookingTypeController;
use App\Http\Controllers\Admin\BookingTypeCostController as AdminBookingTypeCostController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\ApplicantController as AdminApplicantController;
use App\Http\Controllers\Admin\AppointmentDateController as AdminAppointmentDateController;
use App\Http\Controllers\Admin\AppointmentTimeController as AdminAppointmentTimeController;
use App\Http\Controllers\ConfigurationController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::prefix('appointments')->group(function () {
    // The following are appointments stepper, sorted from the first to the least step
    Route::get('', [AppointmentController::class, 'selectBookingType'])->name('appointments.booking-type');
    Route::get('appointment-dates', [AppointmentController::class, 'selectAppointmentDate'])->name('appointments.appointment-date');
    Route::get('applicant-registrations', [AppointmentController::class, 'applicantRegistration'])->name('appointments.applicant-registration');
    Route::get('family-member-registrations', [AppointmentController::class, 'familyMemberRegistration'])->name('appointments.family-member-registration');
    Route::get('applicant-lists', [AppointmentController::class, 'applicantList'])->name('appointments.applicant-list');
    Route::get('checkouts', [AppointmentController::class, 'checkout'])->name('appointments.checkout');

    // Post method
    Route::post('', [AppointmentController::class, 'generateAppointment'])->name('appointments.generate');
    Route::post('store-applicants', [AppointmentController::class, 'storeApplicant'])->name('appointments.store-applicant');
    Route::post('save-appointment-date', [AppointmentController::class, 'saveAppointmentDate'])->name('appointments.save-appointment-date');

    // Ajax API call
    Route::get('slots', [AppointmentController::class, 'getSlot'])->name('appointments.slots');
    Route::get('dates', [AppointmentController::class, 'getDate'])->name('appointments.dates');

    Route::get('/payments/response', [AppointmentController::class, 'paymentResponse'])->name('appointments.payment-response');
    Route::get('/appointments/successful', [AppointmentController::class, 'appointmentSuccessful'])->name('appointments.appointment-successful');

    Route::get('applicant-biodatas', [AppointmentController::class, 'applicantBiodata'])->name('appointments.applicant-biodata');
    Route::post('store-applicant-biodatas', [AppointmentController::class, 'storeApplicantBiodata'])->name('appointments.store-applicant-biodata');
});

// Paystack
Route::post('/paystack/generate', [AppointmentController::class, 'paystackGenerate'])->name('paystack.generate');
Route::get('/paystack/callback', [AppointmentController::class, 'paystackCallback'])->name('paystack.callback');

// Monnify
Route::post('/monnify/callback', [AppointmentController::class, 'monnifyCallback'])->name('monnify.callback');

// Socialite
// Google, Wordpress, Microsoft
Route::get('auth/{provider}', [SocialLoginController::class, 'redirectToProvider'])->name('auth.redirect');
Route::get('auth/google/callback', [SocialLoginController::class, 'handleGoogleCallback']);
Route::get('auth/wordpress/callback', [SocialLoginController::class, 'handleWordpressCallback']);
Route::get('auth/microsoft/callback', [SocialLoginController::class, 'handleMicrosoftCallback']);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']] , function () {
    Route::resource('booking-types', AdminBookingTypeController::class);
    Route::post('booking-types/datatables', [AdminBookingTypeController::class, 'datatables'])->name('booking-types.datatables');
    Route::resource('appointments', AdminAppointmentController::class);
    Route::post('appointments/datatables', [AdminAppointmentController::class, 'datatables'])->name('appointments.datatables');

    Route::resource('booking-types/{bookingTypeId}/costs', AdminBookingTypeCostController::class, [
        'names' => 'booking-type-costs'
    ]);

    Route::resource('applicants', AdminApplicantController::class);

    Route::resource('appointment-dates', AdminAppointmentDateController::class);
    Route::post('appointment-dates/datatables', [AdminAppointmentDateController::class, 'datatables'])->name('appointment-dates.datatables');

    Route::resource('appointment-dates/{appointmentDateId}/appointment-times', AdminAppointmentTimeController::class);
    Route::post('appointment-times/datatables', [AdminAppointmentDateController::class, 'datatables'])->name('appointment-times.datatables');

    Route::post('appointments/datatables', [AdminAppointmentController::class, 'datatables'])->name('appointments.datatables');

    Route::resource('/configurations', ConfigurationController::class)->only(['index', 'update']);

    Route::get('', function() {
        return view('admin.index');
    })->name('index');
});
