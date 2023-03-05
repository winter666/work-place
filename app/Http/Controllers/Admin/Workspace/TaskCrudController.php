<?php

namespace App\Http\Controllers\Admin\Workspace;

use App\Http\Requests\Admin\TaskRequest;
use App\Models\WorkspaceImage\Customer;
use App\Models\WorkspaceImage\Sprint;
use App\Models\WorkspaceImage\Task;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TaskCrudControllerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TaskCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
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
        $workspaceId = $this->crud->getRequest()->workspace;
        CRUD::setModel(Task::class);
        CRUD::setRoute(config('backpack.base.route_prefix') .'/workspace/'. $workspaceId . '/' . (new Task())->getTable());
        CRUD::setEntityNameStrings('task', 'tasks');
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
        CRUD::column('description');
        CRUD::column('priority');
        CRUD::column('status');
        CRUD::column('closed_at');
        CRUD::addColumn([
            'name' => 'sprint.name',
            'label' => trans('workspace.sprint'),
        ]);
        CRUD::addColumn([
            'name' => 'customer.email',
            'label' => trans('workspace.customer'),
        ]);
        CRUD::addColumn([
            'name' => 'tags',
            'label' => 'Tags',
            'type' => 'model_function',
            'function_name' => 'getTagsHtml',
        ]);
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(TaskRequest::class);

        CRUD::field('name');
        CRUD::addField([
            'name'  => 'description',
            'label' => 'Description',
            'type'  => 'summernote',
        ]);
        CRUD::field('priority');
        CRUD::addField([
            'type' => 'select',
            'name' => 'sprint_id',
            'model' => Sprint::class,
            'attribute' => 'name',
            'allows_null' => true,
        ]);
        CRUD::addField([
            'label' => "Tags",
            'type' => 'select_multiple',
            'name' => 'tags',
            'allows_null' => true,
        ]);
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
        CRUD::addField([
            'type' => 'select',
            'name' => 'customer_id',
            'model' => Customer::class,
            'attribute' => 'email',
            'allows_null' => true,
        ]);
    }
}
