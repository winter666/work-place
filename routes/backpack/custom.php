<?php

use App\Http\Controllers\Admin\WorkspaceController;
use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('workspace', 'WorkspaceCrudController');

    // show workspace entries
    Route::middleware('workspace.admin')->prefix('workspace/{workspace}')->group(function () {
        Route::get('entries', [WorkspaceController::class, 'index'])->name('admin.workspace.entries');

        Route::namespace('Workspace')->group(function() {
            Route::crud('customers', 'CustomerCrudController');
        });
    });
}); // this should be the absolute last line of this file
