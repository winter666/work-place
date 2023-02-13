<?php


namespace App\Lib\Workspace;


use App\Lib\Workspace\Migrations\CustomersMigration;
use App\Lib\Workspace\Migrations\SprintsMigration;
use App\Lib\Workspace\Migrations\TasksMigration;

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
}
