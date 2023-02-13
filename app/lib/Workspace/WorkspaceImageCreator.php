<?php


namespace App\Lib\Workspace;


use App\Lib\Workspace\Migrations\AbstractMigration;
use App\Models\Workspace;
use Illuminate\Database\Schema\Blueprint;
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
        $this->workspace->connect()->create('migrations', function (Blueprint $table) {
            $table->string('name');
            $table->timestamps();
        });

        /**
         * @var AbstractMigration $migration
         */
        $completed = [];
        $workspaceTable = DB::connection('workspace')->table('migrations');
        try {
            foreach ($migrations as $migrationClass) {
                $migration = new $migrationClass($this->workspace);
                $migration->up();
                $completed[] = ['name' => $migration->getTable()];
            }

            $workspaceTable->insert($completed);
        } catch (\Exception $e) {
            $workspaceTable->insert($completed);
            throw new \Exception($e->getMessage());
        }
    }

    public function getStatus(): string {
        return $this->status;
    }
}
