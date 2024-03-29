<?php

namespace App\Jobs;

use App\Lib\Workspace\WorkspaceImageCreator;
use App\Lib\Workspace\WorkspaceStatusesConst;
use App\Models\Workspace;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class WorkspaceUpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param Workspace $workspace
     */
    public function __construct(protected Workspace $workspace)
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
            $this->workspace->update(['status' => WorkspaceStatusesConst::STATUS_PROCESSING]);
            $image = new WorkspaceImageCreator($this->workspace);
            $image->install();
            $image->migrate();
        } catch (\Exception $e) {
            Log::debug($e->getMessage(), $e->getTrace());
            $this->status = 'failed';
            $this->workspace->update(['status' => WorkspaceStatusesConst::STATUS_ERROR]);
        }
    }
}
