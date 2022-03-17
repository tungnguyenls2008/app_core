<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes(['register' => false]);

Route::middleware(['auth','localization'])->group(function () {
    Route::get('language/{locale}', function ($locale) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    })->name('change-language');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/get-noti', [App\Http\Controllers\HomeController::class, 'getNotification'])->name('get-noti');
    Route::get('/update-noti', [App\Http\Controllers\HomeController::class, 'updateNotification'])->name('update-noti');
    Route::get('corpcard-import', [App\Http\Controllers\CorpCardController::class, 'importView'])->name('corpcard-import-view');
    Route::get('callback-export', [App\Http\Controllers\BalanceChangeCallbackController::class, 'export'])->name('callback-export');
    Route::get('transfer-export', [App\Http\Controllers\BalanceChangeTransferController::class, 'export'])->name('transfer-export');
    Route::post('transfer-by-import', [App\Http\Controllers\BalanceChangeTransferController::class, 'transferByImport'])->name('transfer-by-import');
    Route::get('get-banks', [App\Http\Controllers\API\CollectOnBehalfAPIController::class, 'ajaxListBanks'])->name('get-banks');
    //Route::get('recheck-transaction', [App\Http\Controllers\API\CollectOnBehalfAPIController::class, 'ajaxRecheck'])->name('recheck-transaction');
    Route::post('corpcard-import', [App\Http\Controllers\CorpCardController::class, 'import'])->name('corpcard-import');
    Route::get('corpcard-export', [App\Http\Controllers\CorpCardController::class, 'export'])->name('corpcard-export');
    Route::get('balance-export', [App\Http\Controllers\SubMerchantBalanceController::class, 'export'])->name('balance-export');

    Route::post('password-change', [\App\Http\Controllers\HomeController::class, 'changePassword'])->name('password-change');
    Route::post('update-profile', [\App\Http\Controllers\HomeController::class, 'updateProfile'])->name('update-profile');
    Route::get('balanceChangeCallbacks/search', [\App\Http\Controllers\BalanceChangeCallbackController::class, 'search'])->name('balanceChange-callback-search');
    Route::get('balanceChangeTransfers/search', [\App\Http\Controllers\BalanceChangeTransferController::class, 'search'])->name('balanceChange-transfer-search');
    Route::get('corpcard/search', [\App\Http\Controllers\CorpCardController::class, 'search'])->name('corpcard-search');
    Route::get('corpcard-create', [\App\Http\Controllers\CorpCardController::class, 'createCorpcard'])->name('corpcard-create');
    Route::get('vietQRs.result', [\App\Http\Controllers\VietQRController::class, 'resultView'])->name('qr-result-view');
    Route::get('ajax-get-account-profile', [App\Http\Controllers\API\CollectOnBehalfAPIController::class, 'ajaxGetAccountProfile'])->name('ajax-get-account-profile');
    Route::get('ajax-get-account-merchant', [App\Http\Controllers\API\CollectOnBehalfAPIController::class, 'ajaxGetAccountMerchant'])->name('ajax-get-account-merchant');

    Route::resource('balanceChangeTransfers', App\Http\Controllers\BalanceChangeTransferController::class)->only('index');
    Route::resource('balanceChangeCallbacks', App\Http\Controllers\BalanceChangeCallbackController::class)->only('index');
    Route::resource('corpCards', App\Http\Controllers\CorpCardController::class)->only('index');
//    Route::resource('merchantBankAccounts', App\Http\Controllers\MerchantBankAccountController::class);
    Route::resource('vietQRs', App\Http\Controllers\VietQRController::class)->except(['edit','update']);
    Route::resource('topupLogs', App\Http\Controllers\TopupLogController::class)->only(['index']);
    Route::resource('balancesChanges', App\Http\Controllers\SubMerchantBalanceController::class)->only(['index']);


});

//Route::get('test_callback',[\App\Http\Controllers\TestCallbackController::class,'processCallback'])->name('test_callback');
//Route::resource('cardIdToNumbers', App\Http\Controllers\CardIdToNumberController::class);
//Route::resource('testCallbacks', App\Http\Controllers\TestCallbackController::class);
