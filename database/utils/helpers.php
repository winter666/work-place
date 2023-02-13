<?php

use Illuminate\Support\Facades\Config;

function connectWorkspace(\App\Models\Workspace $workspace)
{
    Config::set('database.connections.workspace.database', "workspace_{$workspace->id}");
}
