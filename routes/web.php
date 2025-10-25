<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Logout;
use App\Livewire\Cp\DashboardComponent;
use App\Livewire\Cp\Installments\AllocationOfUnitsComponent;
use App\Livewire\Cp\Installments\CollectionComponent;
use App\Livewire\Cp\Installments\Customers\CustomersComponent;
use App\Livewire\Cp\Installments\ReservationsComponent;
use App\Livewire\Cp\Installments\Withdrawal\WithdarawalComponent;
use App\Livewire\Cp\Pdf\CustomerPaymentsComponent;
use App\Livewire\Cp\Pdf\TotalProjectsReportPreviewComponent;
use App\Livewire\Cp\ProjectManagement\ProjectManagementComponent;
use App\Livewire\Cp\Reports\CustomerDateComponent;
use App\Livewire\Cp\Reports\PaymentMovmentComponent;
use App\Livewire\Cp\Reports\TotalProjectsReportComponent;
use App\Livewire\Cp\Settings\SettingsComponent;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('check.license')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', Login::class)->name('login');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/', DashboardComponent::class)->name('dashboard');
        Route::get('/settings', SettingsComponent::class)->name('settings');
        Route::get('/project-management', ProjectManagementComponent::class)->name('project-management');
        Route::get('/customers', CustomersComponent::class)->name('customers');
        Route::get('/allocation-of-units', AllocationOfUnitsComponent::class)->name('allocation-of-units');
        Route::get('/collection', CollectionComponent::class)->name('collection');
        Route::get('/reservations', ReservationsComponent::class)->name('reservations');
        Route::get('/withdrawal', WithdarawalComponent::class)->name('withdrawal');

        /* Reports */

        Route::get('/reports/payment-movements', PaymentMovmentComponent::class)->name('reports.payment-movements');
        Route::get('/reports/totel-projects', TotalProjectsReportComponent::class)->name('reports.totel-projects');
        Route::get('/reports/customer-data', CustomerDateComponent::class)->name('reports.customer-data');
        /* End Reports */

        /*  PDF Reports*/
        Route::get('/pdf/customer-payments/{id}', CustomerPaymentsComponent::class)->name('pdf.customer-payments');
        Route::get('/pdf/total-projects-report', TotalProjectsReportPreviewComponent::class)->name('pdf.total-projects-report');
        /* End PDF Reports*/

        //Logout
        Route::get('/logout', Logout::class)->name('logout');
    });
});


Route::get('/storage-link', function () {
    $targetFolder = storage_path('app/public');
    $linkFolder   = $_SERVER['DOCUMENT_ROOT'] . '/storage';
    symlink($targetFolder, $linkFolder);
});

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/livewire/update', $handle);
});
