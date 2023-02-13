<?php

namespace App\Jobs;

use App\Lib\Workspace\WorkspaceDestroyer;
use App\Models\Workspace;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class WorkspaceDownJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param Workspace $workspace
     */
    public function __construct(protected int $workspace_id)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $service = new WorkspaceDestroyer($this->workspace_id);
            $service->run();
        } catch (\Exception $e) {
            Log::debug($e->getMessage(), $e->getTrace());
        }
    }
}
