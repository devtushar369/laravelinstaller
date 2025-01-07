<?php

use Hashcode\laravelInstaller\Controllers\InstallationController;
use Hashcode\laravelInstaller\Controllers\DatabaseController;
use Hashcode\laravelInstaller\Controllers\AdminSetupController;
use Hashcode\laravelInstaller\Controllers\LicenceVerificationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'installer'])->name('install.')->prefix('install')
    ->group(function () {
        Route::controller(InstallationController::class)->group(function () {
            Route::get('/', 'welcome')->name('welcome');
            Route::get('/check-requirement', 'checkRequirement')->name('check_requirement');
            Route::get('/check-permission', 'checkPermission')->name('check_permission');
            Route::get('/completed', 'completed')->name('completed');
        });

        Route::controller(DatabaseController::class)->group(function (){
            Route::get('/database-setup', 'databaseSetup')->name('database_setup');
            Route::post('/database-setup/store', 'databaseSetupStore')->name('database_setup.store');
        });

        Route::controller(AdminSetupController::class)->group(function (){
            Route::get('/admin-setup', 'adminSetup')->name('admin_setup');
            Route::post('/admin-setup/store', 'adminSetupStore')->name('admin_setup.store');
        });

        Route::controller(LicenceVerificationController::class)->group(function (){
            Route::get('/license-verification', 'licenseVerification')->name('license_verification');
            Route::post('/license-verification/store', 'licenseVerificationStore')->name('license_verification.store');
        });
    });
