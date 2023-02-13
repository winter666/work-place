<?php


namespace App\Lib\Workspace;


use App\Lib\Workspace\Migrations\AbstractMigration;
use App\Models\Workspace;
use Illuminate\Support\Facades\DB;

class WorkspaceImageCreator
{
    protected string $status;

    public function __construct(protected Workspace $workspace)
    {
        //
    }

    public function install()
    {
        $statement = DB::getPdo()->prepare("CREATE DATABASE workspace_{$this->workspace->id}");
        $statement->execute();
        $this->status = 'succeed';
        $this->workspace->update(['status' => WorkspaceStatusesConst::STATUS_COMPLETED]);
    }

    public function migrate()
    {
        $migrations = WorkspaceImageMigrations::getMigrations();

        /**
         * @var AbstractMigration $migration
         */
        foreach ($migrations as $migrationClass) {
            $migration = new $migrationClass($this->workspace);
            $migration->up();
        }
    }

    public function getStatus(): string {
        return $this->status;
    }
}
