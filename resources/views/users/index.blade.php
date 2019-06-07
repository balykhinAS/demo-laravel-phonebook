@extends('layouts.wrap')

@section('')
    {{ $access_edit = Gate::allows('check-access', 'users.edit') }}
    {{ $access_delete = Gate::allows('check-access', 'users.delete') }}
@endsection

@section('wrap-content')
    <div class="page-header clearfix mb-3">
        <h1 class="page-title pull-left">Users</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>@endif
    @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
    @endif

    <div class="card">
        <h5 class="card-header">
            @can('check-access', 'users.delete')
                <div class="float-left">
                    <button data-submit-form=".list-form"
                            data-form-action="{{ route('users.delete.select', request()->all()) }}"
                            data-form-method="delete"
                            class="disabled button-action btn btn-danger">
                        <i class="fa fa-trash-o"></i> Delete
                    </button>
                </div>
            @endcan
            @can('check-access', 'users.add')
                <a href="{{ route('users.create') }}" class="btn btn-primary float-right">
                    <i class="fa fa-plus-circle"></i>
                    Add
                </a>
            @endcan
        </h5>
        <div class="card-body p-0">
            <div class="p-3 bg-light collapse show" id="collapseFilter" style="">
                <form>
                    <div class="form-row">
                        <div class="col-3">
                            <input
                                type="text"
                                name="search[name]"
                                value="{{ request()->input('search.name') }}"
                                class="form-control"
                                onblur="$(this).closest('form').submit()"
                                placeholder="Name"
                            >
                        </div>
                        <div class="col-3">
                            <input
                                type="text"
                                name="search[email]"
                                value="{{ request()->input('search.email') }}"
                                class="form-control"
                                onblur="$(this).closest('form').submit()"
                                placeholder="Email"
                            >
                        </div>
                    </div>
                </form>
            </div>
            <form action="" method="post" class="list-form">
                @csrf
                <table class="table table-hover table-striped mb-0">
                    <thead>
                    <tr>
                        <th>
                            <div class="custom-control custom-checkbox">
                                <input
                                    type="checkbox"
                                    class="custom-control-input select-on-check-all"
                                    id="select-all"
                                    name="selection_all"
                                >
                                <label class="custom-control-label cursor-pointer" for="select-all"></label>
                            </div>
                        </th>
                        <th scope="col">
                            <a href="{{ route('users.index', array_merge(request()->all(), [
                                'sort' => 'name',
                                'direction' => $sort == 'name' ? ($direction == 'desc' ? 'asc' : 'desc') : null,
                            ])) }}">Name @if($sort == 'name') @if($direction == 'desc')↑@else↓@endif @endif</a>
                        </th>
                        <th scope="col">
                            <a href="{{ route('users.index', array_merge(request()->all(), [
                                'sort' => 'email',
                                'direction' => $sort == 'email' ? ($direction == 'desc' ? 'asc' : 'desc') : null
                            ])) }}">Email @if($sort == 'email') @if($direction == 'desc')↑@else↓@endif @endif</a>
                        </th>
                        <th></th>
                    </tr>
                    <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="select-{{ $user->id }}"
                                    name="select[]"
                                    value="{{ $user->id }}"
                                >
                                <label class="custom-control-label cursor-pointer" for="select-{{ $user->id }}"></label>
                            </div>
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <div class="float-right">
                                @if($access_edit)
                                    <a href="{{ route('users.edit', $user) }}"
                                       class="btn btn-outline-secondary btn-sm"
                                       data-toggle="tooltip"
                                       data-original-title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                @endif
                                @if($access_delete)
                                    <a href="{{ route('users.delete', $user->id) }}"
                                       data-method="DELETE"
                                       data-confirm="Confirm"
                                       class="btn btn-outline-secondary btn-sm"
                                       data-toggle="tooltip"
                                       data-original-title="Delete">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </form>
        </div>
        <div class="card-footer pt-4 pb-2">
            {{ $users->appends(request()->all())->links() }}
        </div>
    </div>
@endsection