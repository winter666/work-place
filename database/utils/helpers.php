<?php

use App\Models\Workspace;
use Illuminate\Support\Facades\Config;

function connectWorkspace(Workspace $workspace)
{
    Config::set('database.connections.workspace.database', "workspace_{$workspace->id}");
}
