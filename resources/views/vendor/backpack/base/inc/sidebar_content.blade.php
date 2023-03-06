{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
@php
    /**
     * @var Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade $crud
     */
@endphp
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
@if (backpack_user()->is_admin)
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> {{ trans('system.users') }}</a></li>
@endif

<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('workspace') }}"><i class="nav-icon la la-database"></i> {{ trans('system.workspaces') }}</a>
    @if (isset($crud) && $crud->getRequest()->workspace)
        <ul>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.workspace.entries', ['workspace' => $crud->getRequest()->workspace]) }}"><i class="nav-icon la la-home"></i> {{ trans('workspace.home') }}</a></li>
            @foreach(App\Lib\Workspace\WorkspaceImageMigrations::getEntries() as $entry)
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('workspace', ['workspace' => $crud->getRequest()->workspace, 'entry' => $entry->getSubject()]) }}"><i class="nav-icon la la-{{ $entry->getIcon() }}"></i> {{ trans('workspace.' . $entry->getSubject()) }}</a></li>
            @endforeach
        </ul>
    @endif
</li>
