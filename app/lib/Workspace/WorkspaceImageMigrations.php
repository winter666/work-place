<?php


namespace App\Lib\Workspace;


use App\Lib\Workspace\Migrations\CustomersMigration;

class WorkspaceImageMigrations
{
    public static function getMigrations(): array
    {
        return [
            CustomersMigration::class,
        ];
    }
}
