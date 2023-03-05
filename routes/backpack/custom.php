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
        ['backpack.auth'],
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes

    Route::middleware('check_admin')->group(function () {
        Route::crud('user', 'UserCrudController');
    });

    Route::crud('workspace', 'WorkspaceCrudController');

    // show workspace entries
    Route::middleware('workspace.set')->prefix('workspace/{workspace}')->group(function () {
        Route::get('entries', [WorkspaceController::class, 'index'])->name('admin.workspace.entries');

        Route::namespace('Workspace')->group(function() {
            Route::crud('customers', 'CustomerCrudController');
            Route::crud('sprints', 'SprintCrudController');
            Route::crud('tasks', 'TaskCrudController');
            Route::crud('tags', 'TagCrudController');
        });
    });
}); // this should be the absolute last line of this file
