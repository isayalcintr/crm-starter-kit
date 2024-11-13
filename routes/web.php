<?php

use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Offer\OfferController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;




Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('location/select-cities', [LocationController::class, 'selectCities'])->name('location.select.cities');
    Route::get('location/select-districts/{cityId}', [LocationController::class, 'selectDistricts'])->name('location.select.districts');

    Route::get('group/select', [GroupController::class, 'select'])->name('group.select');
    Route::get('group/select-section', [GroupController::class, 'selectSection'])->name('group.select.section');
    Route::get('group/select-type/{section}', [GroupController::class, 'selectType'])->name('group.select.type');
    Route::get('group/list-with-datatable', [GroupController::class, 'listWithDatatable'])->name('role.list.with.datatable');
    Route::resource('group', GroupController::class);

    Route::get('product/select', [ProductController::class, 'select'])->name('product.select');
    Route::get('product/list-with-datatable', [ProductController::class, 'listWithDatatable'])->name('product.list.with.datatable');
    Route::resource('product', ProductController::class);

    Route::get('customer/select', [CustomerController::class, 'select'])->name('customer.select');
    Route::get('customer/list-with-datatable', [CustomerController::class, 'listWithDatatable'])->name('customer.list.with.datatable');
    Route::resource('customer', CustomerController::class);

    Route::get('offer/list-with-datatable', [OfferController::class, 'listWithDatatable'])->name('offer.list.with.datatable');
    Route::patch('offer/{offer}/cancel', [OfferController::class, 'cancel'])->name('offer.cancel');
    Route::put('offer/{offer}/change-stage', [OfferController::class, 'changeStage'])->name('offer.change.stage');
    Route::resource('offer', OfferController::class);

    Route::get('service/list-with-datatable', [ServiceController::class, 'listWithDatatable'])->name('service.list.with.datatable');
    Route::resource('service', ServiceController::class);

    Route::get('task/list-with-datatable', [TaskController::class, 'listWithDatatable'])->name('task.list.with.datatable');
    Route::resource('task', TaskController::class);

    Route::get('interview/list-with-datatable', [InterviewController::class, 'listWithDatatable'])->name('interview.list.with.datatable');
    Route::resource('interview', InterviewController::class);

    Route::get('role/list-with-datatable', [RoleController::class, 'listWithDatatable'])->name('role.list.with.datatable');
    Route::resource('role', RoleController::class);

    Route::get('user/list-with-datatable', [UserController::class, 'listWithDatatable'])->name('user.list.with.datatable');
    Route::resource('user', UserController::class);

});

require __DIR__.'/auth.php';
