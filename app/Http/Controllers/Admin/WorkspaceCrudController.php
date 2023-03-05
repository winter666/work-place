<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\WorkspaceRequest;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\RedirectResponse;

/**
 * Class WorkspaceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class WorkspaceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Workspace::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/workspace');
        CRUD::setEntityNameStrings('workspace', 'workspaces');
        if (!backpack_user()->is_admin) {
            $this->crud->query->where('user_id', backpack_user()->id);
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('name');
        CRUD::column('status');
        CRUD::column('app_key');
        if (backpack_user()->is_admin) {
            CRUD::addColumn([
                'name' => 'user.email',
                'label' => 'User',
            ]);
        }

        $this->crud->addButtonFromModelFunction('line', 'enter', 'enterWorkspaceView', 'beginning');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(WorkspaceRequest::class);

        CRUD::field('name');
        if (backpack_user()->is_admin) {
            CRUD::addField([
                'label' => 'User',
                'type' => 'select',
                'name' => 'user_id',
                'model' => User::class,
                'attribute' => 'email',
            ]);
        }
    }

    public function store(): RedirectResponse
    {
        $this->crud->setRequest($this->crud->validateRequest());

        $request = $this->crud->getRequest();
        if (!$request->input('user_id')) {
            $request->request->set('user_id', backpack_user()->id);
        }

        $this->crud->setRequest($request);
        $this->crud->unsetValidation();
        $this->crud->field('user_id');
        return $this->traitStore();
    }


    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
