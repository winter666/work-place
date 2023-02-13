<?php

namespace App\Lib\Workspace\Migrations;

use App\Models\Workspace;
use Illuminate\Database\Schema\Builder;

abstract class AbstractMigration
{
    protected Builder $schema;

    public function __construct(protected Workspace $workspace)
    {

    }

    abstract public function up();
    abstract public function down();
}
