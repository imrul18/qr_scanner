<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaterkitController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\PublicTicketController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;

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



Route::get('login', [AuthenticationController::class, 'loginPage'])->name('login-page');
Route::post('login', [AuthenticationController::class, 'login'])->name('login');
Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');

Route::get('event/ticket/{uuid}', [PublicTicketController::class, 'showTicket'])->name('show_ticket');
Route::post('add-to-wallet', [PublicTicketController::class, 'addToWallet'])->name('add-to-wallet');

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('scanner-page');
    });

    Route::get('users', [UserController::class, 'userList'])->name('user-list-page');
    Route::get('new-user', [UserController::class, 'userAddPage'])->name('user-add-page');
    Route::post('new-user', [UserController::class, 'userAdd'])->name('user-add');
    Route::get('edit-user/{id}', [UserController::class, 'userEditPage'])->name('user-edit-page');
    Route::post('edit-user/{id}', [UserController::class, 'userEdit'])->name('user-edit');
    Route::post('delete-user/{id}', [UserController::class, 'userDelete'])->name('user-delete');

    Route::get('events', [EventController::class, 'eventList'])->name('event-list-page');
    Route::get('new-event', [EventController::class, 'eventAddPage'])->name('event-add-page');
    Route::post('new-event', [EventController::class, 'eventAdd'])->name('event-add');
    Route::get('edit-event/{id}', [EventController::class, 'eventEditPage'])->name('event-edit-page');
    Route::post('edit-event/{id}', [EventController::class, 'eventEdit'])->name('event-edit');
    Route::post('delete-event/{id}', [EventController::class, 'eventDelete'])->name('event-delete');
    Route::get('view-event/{id}', [EventController::class, 'eventViewPage'])->name('event-view-page');
    Route::get('export-ticket/{id}', [EventController::class, 'ExportQrCode'])->name('export-qr-code');
    Route::get('view-event-ticket/{id}', [EventController::class, 'eventTicketViewPage'])->name('event-ticket-view-page');
    Route::post('upload-ticket/{id}', [EventController::class, 'TicketUpload'])->name('ticket-upload');
    Route::get('nfc-set/{id}', [EventController::class, 'nfcSet'])->name('nfc-set');

    Route::get('scanner', [ScanController::class, 'scannerPage'])->name('scanner-page');
    Route::post('ticket-scan', [ScanController::class, 'ticketScan'])->name('ticket-scan');

    Route::get('settings', [SettingsController::class, 'settingsPage'])->name('settings-page');
    Route::post('settings-update', [SettingsController::class, 'settingsupdate'])->name('settings-update');
});

// Route Components
Route::get('layouts/collapsed-menu', [StaterkitController::class, 'collapsed_menu'])->name('collapsed-menu');
Route::get('layouts/full', [StaterkitController::class, 'layout_full'])->name('layout-full');
Route::get('layouts/without-menu', [StaterkitController::class, 'without_menu'])->name('without-menu');
Route::get('layouts/empty', [StaterkitController::class, 'layout_empty'])->name('layout-empty');
Route::get('layouts/blank', [StaterkitController::class, 'layout_blank'])->name('layout-blank');
// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);
