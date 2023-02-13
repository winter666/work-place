<?php


namespace App\Lib\Workspace;


use Illuminate\Support\Facades\DB;

class WorkspaceDestroyer
{
    public function __construct(protected int $workspace_id)
    {
        //
    }

    public function run()
    {
        $statement = DB::getPdo()->prepare("DROP DATABASE workspace_{$this->workspace_id}");
        $statement->execute();
    }
}
