@extends(backpack_view('blank'))

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    <table class="table table-active">
        <thead>
            <tr>
                <th class="col-10">Entity</th>
                <th class="col-2"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($entities as $entity)
                <tr>
                    <td>{{ $entity->getTable() }}</td>
                    <td>
                        <a
                            class="btn btn-sm btn-link"
                            href="{{ backpack_url('workspace', ['workspace' => $workspace, 'entry' => $entity->getTable()]) }}"
                        >
                            <i class="la la-eye"></i> View
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
