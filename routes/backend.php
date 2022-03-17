<?php

use App\Http\Controllers\CaptchaServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/backend', function () {
    return view('_backend.auth.login');
});

//===================BACKEND AUTH ROUTES===============================
Route::get('backend/login', [\App\Http\Controllers\_Backend\Auth\LoginController::class, 'showLoginForm'])->name('backend-login-view');
Route::post('backend/login', [\App\Http\Controllers\_Backend\Auth\LoginController::class,'login'])->name('backend-login');
Route::post('backend/logout',  [\App\Http\Controllers\_Backend\Auth\LoginController::class,'logout'])->name('backend-logout');

//// Registration Routes...
Route::get('backend/register', [\App\Http\Controllers\_Backend\Auth\RegisterController::class, 'showRegistrationForm'])->name('backend-register-view');
Route::post('backend/register', [\App\Http\Controllers\_Backend\Auth\RegisterController::class, 'register'])->name('backend-register');

// Password Reset Routes...
Route::get('backend/password/reset', [\App\Http\Controllers\_Backend\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('backend-password.request');
Route::post('backend/password/email', [\App\Http\Controllers\_Backend\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('backend-password.email');
Route::get('backend/password/reset/{token}', [\App\Http\Controllers\_Backend\Auth\ForgotPasswordController::class, 'showResetForm'])->name('backend-password.reset');
Route::post('backend/password/reset', [\App\Http\Controllers\_Backend\Auth\ForgotPasswordController::class, 'reset'])->name('backend-password.update');

// Confirm Password
Route::get('backend/password/confirm', [\App\Http\Controllers\_Backend\Auth\ConfirmPasswordController::class, 'showConfirmForm'])->name('backend-password.confirm');
Route::post('backend/password/confirm', [\App\Http\Controllers\_Backend\Auth\ConfirmPasswordController::class, 'backend-confirm']);

// Email Verification Routes...
Route::get('backend/email/verify', [\App\Http\Controllers\_Backend\Auth\VerificationController::class, 'show'])->name('backend-verification.notice');
Route::get('backend/email/verify/{id}/{hash}', [\App\Http\Controllers\_Backend\Auth\VerificationController::class, 'verify'])->name('backend-verification.verify');
Route::get('backend/email/resend',  [\App\Http\Controllers\_Backend\Auth\VerificationController::class, 'resend'])->name('backend-verification.resend');

//================================END======================================
Route::middleware(['auth:backend','checkPermission'])->prefix('backend')->group(function () {
    Route::get('clear-route',function (){
        clearRouteCache();
        return 'Routes cleared!';
    });
    Route::get('home',[\App\Http\Controllers\_Backend\HomeController::class,'index'])->name('backend-home');
    Route::post('password-change', [\App\Http\Controllers\_Backend\HomeController::class, 'changePassword'])->name('backend-password-change');
    Route::get('backend-operator-log-export', [App\Http\Controllers\_Backend\OperatorLogController::class, 'export'])->name('backend-operator-log-export');

    Route::get('merchant/create', [\App\Http\Controllers\_Backend\Auth\MerchantRegisterController::class, 'showRegistrationForm'])->name('merchant-register-view');
    Route::post('merchant/create', [\App\Http\Controllers\_Backend\Auth\MerchantRegisterController::class, 'register'])->name('merchant-register');
    Route::get('merchant-change-default-card',[\App\Http\Controllers\_Backend\MerchantController::class,'changeDefaultCard'])->name('merchant-change-default-card');
    Route::get('merchant-toggle-lock',[\App\Http\Controllers\_Backend\Auth\MerchantRegisterController::class,'toggleLock'])->name('merchant-toggle-lock');
    Route::get('merchant/password/reset', [\App\Http\Controllers\_Backend\Auth\MerchantForgotPasswordController::class, 'showLinkRequestForm'])->name('merchant-password.request');
    Route::post('merchant/password/email', [\App\Http\Controllers\_Backend\Auth\MerchantForgotPasswordController::class, 'sendResetLinkEmail'])->name('merchant-password.email');
    Route::get('merchant/password/reset', [\App\Http\Controllers\_Backend\Auth\MerchantForgotPasswordController::class, 'showResetForm'])->name('merchant-password.reset');
    Route::post('merchant/password/reset', [\App\Http\Controllers\_Backend\Auth\MerchantForgotPasswordController::class, 'reset'])->name('merchant-password.update');

    Route::get('sub-merchant/create', [\App\Http\Controllers\_Backend\Auth\SubMerchantRegisterController::class, 'showRegistrationForm'])->name('sub-merchant-register-view');
    Route::post('sub-merchant/create', [\App\Http\Controllers\_Backend\Auth\SubMerchantRegisterController::class, 'register'])->name('sub-merchant-register');
    Route::get('sub-merchant-increase-balance',[\App\Http\Controllers\_Backend\SubMerchantController::class,'increaseBalance'])->name('sub-merchant-increase-balance');
    Route::get('sub-merchant-decrease-balance',[\App\Http\Controllers\_Backend\SubMerchantController::class,'decreaseBalance'])->name('sub-merchant-decrease-balance');
    Route::get('sub-merchant-change-default-card',[\App\Http\Controllers\_Backend\SubMerchantController::class,'changeDefaultCard'])->name('sub-merchant-change-default-card');
    Route::get('sub-merchant-toggle-lock',[\App\Http\Controllers\_Backend\Auth\SubMerchantRegisterController::class,'toggleLock'])->name('sub-merchant-toggle-lock');
    Route::get('sub-merchant-toggle-re-transferable',[\App\Http\Controllers\_Backend\SubMerchantController::class,'toggleReTransferable'])->name('sub-merchant-toggle-re-transferable');
    Route::get('sub-merchant-set-transfer-limit',[\App\Http\Controllers\_Backend\SubMerchantController::class,'setTransferLimit'])->name('sub-merchant-set-transfer-limit');
    Route::get('sub-merchant/password/reset', [\App\Http\Controllers\_Backend\Auth\SubMerchantForgotPasswordController::class, 'showLinkRequestForm'])->name('sub-merchant-password.request');
    Route::post('sub-merchant/password/email', [\App\Http\Controllers\_Backend\Auth\SubMerchantForgotPasswordController::class, 'sendResetLinkEmail'])->name('sub-merchant-password.email');
    Route::get('sub-merchant/password/reset', [\App\Http\Controllers\_Backend\Auth\SubMerchantForgotPasswordController::class, 'showResetForm'])->name('sub-merchant-password.reset');
    Route::post('sub-merchant/password/reset', [\App\Http\Controllers\_Backend\Auth\SubMerchantForgotPasswordController::class, 'reset'])->name('sub-merchant-password.update');

    Route::get('captcha-validation', [CaptchaServiceController::class, 'captchaFormValidate'])->name('captcha-validation');
    Route::get('reload-captcha', [CaptchaServiceController::class, 'reloadCaptcha'])->name('reload-captcha');
    Route::resource('merchants', App\Http\Controllers\_Backend\MerchantController::class)->only(['index','create']);
    Route::resource('sub-merchants', App\Http\Controllers\_Backend\SubMerchantController::class)->only(['index','create']);
    Route::resource('feeConfigs', App\Http\Controllers\_Backend\FeeConfigController::class)->only(['index','create','store']);
    Route::resource('operatorLogs', App\Http\Controllers\_Backend\OperatorLogController::class)->only(['index']);
    Route::resource('roles', App\Http\Controllers\_Backend\RoleController::class);
    Route::resource('users', App\Http\Controllers\_Backend\UserController::class)->except(['destroy']);

});


