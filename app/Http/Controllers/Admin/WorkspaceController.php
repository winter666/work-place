<?php

namespace App\Http\Controllers\Admin;

use App\Lib\Workspace\WorkspaceImageMigrations;
use App\Models\Workspace;
use App\Models\WorkspaceImage\Customer;
use App\Models\WorkspaceImage\Sprint;
use Illuminate\Routing\Controller;

/**
 * Class WorkspaceControllerController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class WorkspaceController extends Controller
{
    public function index(Workspace $workspace)
    {
        return view('admin.workspace', [
            'title' => $workspace->name,
            'breadcrumbs' => [
                trans('backpack::crud.admin') => backpack_url('dashboard'),
                'WorkspaceController' => false,
            ],
            'page' => 'resources/views/admin/workspace.blade.php',
            'controller' => 'app/Http/Controllers/Admin/WorkspaceController.php',
            'entities' => WorkspaceImageMigrations::getEntries(),
            'workspace' => $workspace,
        ]);
    }
}
