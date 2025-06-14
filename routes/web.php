<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Logout;
use App\Livewire\Cp\DashboardComponent;
use App\Livewire\Cp\Installments\AllocationOfUnitsComponent;
use App\Livewire\Cp\Installments\Customers\CustomersComponent;
use App\Livewire\Cp\ProjectManagement\ProjectManagementComponent;
use App\Livewire\Cp\Settings\SettingsComponent;
use Illuminate\Support\Facades\Route;

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

Route::middleware('guest')->group(function(){
    Route::get('/login', Login::class)->name('login');

});

Route::middleware('auth')->group(function(){
    Route::get('/', DashboardComponent::class)->name('dashboard');
    Route::get('/settings',SettingsComponent::class)->name('settings');
    Route::get('/project-management', ProjectManagementComponent::class)->name('project-management');
    Route::get('/customers',CustomersComponent::class)->name('customers');
    Route::get('/allocation-of-units',AllocationOfUnitsComponent::class)->name('allocation-of-units');
    //Logout
    Route::get('/logout', Logout::class)->name('logout');

});
