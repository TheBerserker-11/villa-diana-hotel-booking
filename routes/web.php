<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\RoomControllerA as AdminRoomController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\AdminProfileController;

/*
|--------------------------------------------------------------------------
| PUBLIC + USER ROUTES (Admins are forced to /admin)
|--------------------------------------------------------------------------
| ✅ If admin is logged in and tries to open ANY route here -> redirect('/admin')
 */
Route::get('/media', MediaController::class)->name('media.show');

Route::middleware('admin.redirect')->group(function () {

    Route::get('/', [PageController::class, 'index'])->name('home');

    Route::prefix('rooms')->group(function () {
        Route::get('/', [PageController::class, 'list_rooms'])->name('rooms.index');
        Route::post('/', [PageController::class, 'search'])->name('search');
        Route::get('/{room}', [PageController::class, 'showRoom'])->name('rooms.show');
    });

    Route::get('/room-tour/{id}', [PageController::class, 'showRoomTour'])->name('room-tour');

    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/search', [EventController::class, 'search'])->name('search');
        Route::get('/{event}', [EventController::class, 'show'])->name('show');
    });

    Route::prefix('amenities')->name('amenities.')->group(function () {
        Route::get('/brickyard', [AmenityController::class, 'brickyard'])->name('brickyard');
        Route::get('/swim', [AmenityController::class, 'swim'])->name('swim');
        Route::get('/activities', [AmenityController::class, 'activities'])->name('activities');
    });

    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');

    Route::view('/about', 'about')->name('about');
    Route::view('/contact', 'contact')->name('contact');
    Route::view('/faq', 'faq')->name('faq');
    Route::view('/privacy-policy', 'privacy')->name('privacy');
    Route::view('/terms-and-conditions', 'terms')->name('terms');

    Route::prefix('rooms/{room}/feedbacks')->group(function () {
        Route::post('/', [FeedbackController::class, 'store'])->name('feedback.store');
        Route::get('/', [FeedbackController::class, 'show'])->name('feedback.show');
    });

    // Booking summary is public (guest can land here and then login/register)
    Route::get('/booking/summary', [OrderController::class, 'summary'])->name('booking.summary');

    /*
    |--------------------------------------------------------------------------
    | AUTH (guest)
    |--------------------------------------------------------------------------
    */
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);

        Route::prefix('auth/google')->name('auth.google.')->group(function () {
            Route::get('/login', [GoogleAuthController::class, 'redirectToGoogleForLogin'])->name('login');
            Route::get('/register', [GoogleAuthController::class, 'redirectToGoogleForRegister'])->name('register');
            Route::get('/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('callback');
        });

        Route::prefix('register')->group(function () {
            Route::get('/', [CustomerController::class, 'showRegisterForm'])->name('register');
            Route::post('/send-otp', [CustomerController::class, 'sendOtp'])->name('send.otp');
            Route::post('/verify-otp', [CustomerController::class, 'verifyOtp'])->name('verify.otp');
            Route::post('/details', [CustomerController::class, 'registerFinal'])->name('register.final');
        });

        Route::prefix('password')->name('password.')->group(function () {
            Route::get('/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('request');
            Route::post('/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('email');
            Route::get('/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('reset');
            Route::post('/reset', [ResetPasswordController::class, 'reset'])->name('update');
        });
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/password/reset-success', [ResetPasswordController::class, 'success'])->name('password.success');

        Route::get('/bookings/create', [OrderController::class, 'create'])->name('bookings.create');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/my-bookings', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/notifications/bookings/live', [OrderController::class, 'notificationsLive'])->name('notifications.bookings.live');

        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

        Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/reset-password', [ProfileController::class, 'resetPassword'])->name('profile.reset-password');
        Route::delete('/profile/delete', [CustomerController::class, 'destroy'])->name('user.destroy');
    });
});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Admins only)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/dashboard/live', [AdminController::class, 'live'])->name('dashboard.live');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/bookings/live-data', [AdminOrderController::class, 'liveData'])->name('bookings.liveData');
    Route::get('/orders/export', [AdminOrderController::class, 'exportBookings'])->name('orders.export');
    Route::resource('orders', AdminOrderController::class)->except(['index']);

    Route::resource('rooms', AdminRoomController::class)->except(['show']);
    Route::resource('roomtypes', RoomTypeController::class)->except(['show']);

    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [AdminCustomerController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminCustomerController::class, 'show'])->name('show');
        Route::delete('/{id}', [AdminCustomerController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('report')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('report');
        Route::get('/pdf', [ReportController::class, 'exportReportPdf'])->name('report.pdf');
        Route::get('/live', [ReportController::class, 'live'])->name('report.live');
    });

    Route::get('/profile', [AdminProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [AdminProfileController::class, 'changePassword'])->name('profile.password');

    Route::get('/references', [AdminOrderController::class, 'referenceAnalytics'])->name('references');
    Route::get('/references/export', [AdminOrderController::class, 'exportReferences'])->name('references.export');

    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [AdminEventController::class, 'index'])->name('index');
        Route::get('/create', [AdminEventController::class, 'create'])->name('create');
        Route::post('/', [AdminEventController::class, 'store'])->name('store');
        Route::get('/{event}/edit', [AdminEventController::class, 'edit'])->name('edit');
        Route::put('/{event}', [AdminEventController::class, 'update'])->name('update');
        Route::delete('/{event}', [AdminEventController::class, 'destroy'])->name('destroy');

        Route::post('/{event}/images', [AdminEventController::class, 'uploadImages'])->name('images.upload');
        Route::delete('/images/{image}', [AdminEventController::class, 'destroyImage'])->name('images.destroy');
    });
});
