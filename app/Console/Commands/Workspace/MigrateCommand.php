<?php

namespace App\Console\Commands\Workspace;

use App\Lib\Workspace\Migrations\AbstractMigration;
use App\Lib\Workspace\WorkspaceImageMigrations;
use App\Models\Workspace;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workspace:migrate {--workspace_id=} {--rollback}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Just command for migrate and rollback some or all workspace';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $workspaceId = $this->option('workspace_id');
        if ((bool) $this->option('rollback')) {
            $this->info('Rollback migrations');
        } else {
            $this->info('Start migrations');
        }

        /**
         * @var Workspace $workspace
         */
        if (is_null($workspaceId)) {
            $workspaces = Workspace::all();
            foreach ($workspaces as $workspace) {
                $this->processToWorkspace($workspace);
            }

            return Command::SUCCESS;
        }

        $workspace = Workspace::query()->findOrFail($workspaceId);
        $this->processToWorkspace($workspace);

        return Command::SUCCESS;
    }

    private function processToWorkspace(Workspace $workspace) {
        $this->info('Processing for workspace #' . $workspace->id);
        $isRollback = (bool) $this->option('rollback');
        $workspace->connect();
        $migrationData = $this->getMigrations($workspace);

        $migrationModel = DB::connection('workspace')
            ->table('migrations');

        $tables = $migrationModel
            ->orderByDesc('id')
            ->get(['id', 'name'])
            ->pluck('name')
            ->unique()
            ->values();

        if ($isRollback) {
            $deleted = [];
            foreach ($tables as $table) {
                if (isset($migrationData[$table])) {
                    foreach ($migrationData[$table] as $migration) {
                        $this->processItem($table, function () use ($migration) {
                            $migration->down();
                        });
                    }

                    $deleted[] = $table;
                }
            }

            $migrationModel->whereIn('name', $deleted)->delete();
            $this->info('workspace #' . $workspace->id . ' rolled back successfully');
        } else {
            $tableMigrations = array_keys($migrationData);
            $diff = collect($tableMigrations)->diff($tables)
                ->values();

            $completed = [];
            foreach ($diff as $table) {
                foreach ($migrationData[$table] as $migration) {
                    $this->processItem($table, function () use ($migration, &$completed) {
                        $migration->up();
                        $completed[] = ['name' => $migration->getTable(), 'created_at' => Carbon::now()];
                    });
                }
            }

            $migrationModel->insert($completed);
            $this->info('workspace #' . $workspace->id . ' migrated successfully');
        }
    }

    private function getMigrations(Workspace $workspace) {
        $migrations = WorkspaceImageMigrations::getMigrations();
        $migrationData = [];

        /**
         * @var AbstractMigration $migration
         */
        foreach ($migrations as $migrationClass) {
            $migration = new $migrationClass($workspace);
            $migrationData[$migration->getTable()][] = $migration;
        }

        return $migrationData;
    }

    private function processItem(string $target, callable $closure) {
        $this->info('[#'.$target.'] start...');
        $closure();
        $this->info('[#'.$target.'] success');
    }
}
