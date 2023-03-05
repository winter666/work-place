<?php


namespace App\Lib\Workspace;


use App\Lib\Workspace\Migrations\AbstractMigration;
use App\Models\Workspace;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        $this->workspace->update(['status' => WorkspaceStatusesConst::STATUS_COMPLETED, 'app_key' => Hash::make(Str::random(32))]);
    }

    public function migrate()
    {
        $migrations = WorkspaceImageMigrations::getMigrations();
        $this->workspace->connect()->create('migrations', function (Blueprint $table) {
            $table->id();
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
                $completed[] = ['name' => $migration->getTable(), 'created_at' => Carbon::now()];
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
