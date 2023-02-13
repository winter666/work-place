<?php

namespace App\Observers;

use App\Jobs\WorkspaceUpJob;
use App\Models\Workspace;

class WorkspaceObserver
{
    /**
     * Handle the Workspace "created" event.
     *
     * @param  \App\Models\Workspace  $workspace
     * @return void
     */
    public function created(Workspace $workspace)
    {
        WorkspaceUpJob::dispatch($workspace);
    }

    /**
     * Handle the Workspace "updated" event.
     *
     * @param  \App\Models\Workspace  $workspace
     * @return void
     */
    public function updated(Workspace $workspace)
    {
        //
    }

    /**
     * Handle the Workspace "deleted" event.
     *
     * @param  \App\Models\Workspace  $workspace
     * @return void
     */
    public function deleted(Workspace $workspace)
    {
        //
    }

    /**
     * Handle the Workspace "restored" event.
     *
     * @param  \App\Models\Workspace  $workspace
     * @return void
     */
    public function restored(Workspace $workspace)
    {
        //
    }

    /**
     * Handle the Workspace "force deleted" event.
     *
     * @param  \App\Models\Workspace  $workspace
     * @return void
     */
    public function forceDeleted(Workspace $workspace)
    {
        //
    }
}
