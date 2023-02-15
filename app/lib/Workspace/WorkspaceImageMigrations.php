<?php


namespace App\Lib\Workspace;


use App\Lib\Backpack\WorkspaceEntry;
use App\Lib\Workspace\Migrations\CustomersMigration;
use App\Lib\Workspace\Migrations\SprintsMigration;
use App\Lib\Workspace\Migrations\TasksMigration;
use App\Models\WorkspaceImage\Customer;
use App\Models\WorkspaceImage\Sprint;
use App\Models\WorkspaceImage\Task;

class WorkspaceImageMigrations
{
    public static function getMigrations(): array
    {
        return [
            CustomersMigration::class,
            SprintsMigration::class,
            TasksMigration::class,
        ];
    }

    public static function getEntries(): array {
        return [
            new WorkspaceEntry(new Customer(), 'user'),
            new WorkspaceEntry(new Sprint(), 'stream'),
            new WorkspaceEntry(new Task(), 'file-alt'),
        ];
    }
}
