@extends('layouts.wrap')

@section('')
    {{ $access_edit = Gate::allows('check-access', 'contacts.edit') }}
    {{ $access_delete = Gate::allows('check-access', 'contacts.delete') }}
@endsection

@section('wrap-content')
    <div class="page-header clearfix mb-3">
        <h1 class="page-title pull-left">Contacts</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>@endif
    @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="float-left mr-2">
                <div class="btn-group">
                    <button
                        class="disabled button-action btn btn-secondary dropdown-toggle"
                        type="button"
                        id="dropdownStatus"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        disabled
                    ><i class="fa fa-star-o"></i> Favorites</button>
                    <div class="dropdown-menu" aria-labelledby="dropdownStatus">
                        <a
                            href="#"
                            class="dropdown-item"
                            data-submit-form=".list-form"
                            data-form-action="{{ route('contacts.favorites.add.select') }}"
                            data-form-method="post"
                        >Add</a>
                        <a
                            href="#"
                            class="dropdown-item"
                            data-submit-form=".list-form"
                            data-form-action="{{ route('contacts.favorites.remove.select') }}"
                            data-form-method="delete"
                        >Remove</a>
                    </div>
                </div>
            </div>

            <div class="float-left mr-2">
                <div class="btn-group">
                    <button
                        class="disabled button-action btn btn-warning dropdown-toggle"
                        type="button"
                        id="dropdownStatus"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        disabled
                    ><i class="fa fa-file-excel-o"></i> Export</button>
                    <div class="dropdown-menu" aria-labelledby="dropdownStatus">
                        <a
                            href="#"
                            class="dropdown-item"
                            data-submit-form=".list-form"
                            data-form-action="{{ route('contacts.export', 'xls') }}"
                            data-form-method="post"
                        >xls</a>
                        <a
                            href="#"
                            class="dropdown-item"
                            data-submit-form=".list-form"
                            data-form-action="{{ route('contacts.export', 'csv') }}"
                            data-form-method="post"
                        >csv</a>
                        <a
                            href="#"
                            class="dropdown-item"
                            data-submit-form=".list-form"
                            data-form-action="{{ route('contacts.export', 'xlsx') }}"
                            data-form-method="post"
                        >xlsx</a>
                        <a
                            href="#"
                            class="dropdown-item"
                            data-submit-form=".list-form"
                            data-form-action="{{ route('contacts.export', 'pdf') }}"
                            data-form-method="post"
                        >pdf</a>
                    </div>
                </div>
            </div>

            @can('check-access', 'contacts.delete')
            <div class="float-left">
                <button data-submit-form=".list-form"
                        data-form-action="{{ route('contacts.delete.select') }}"
                        data-form-method="delete"
                        class="disabled button-action btn btn-danger">
                    <i class="fa fa-trash-o"></i> Delete
                </button>
            </div>
            @endcan
            @can('check-access', 'contacts.add')
                <a href="{{ route('contacts.create') }}" class="btn btn-primary float-right">
                    <i class="fa fa-plus-circle"></i>
                    Add
                </a>
            @endcan
        </div>
        <div class="card-body p-0">
            <div class="p-3 bg-light collapse show" id="collapseFilter" style="">
                <form>
                    <div class="form-row mb-3">
                        <div class="col-3">
                            <div class="custom-control custom-switch">
                                <input type="checkbox"
                                       class="custom-control-input"
                                       id="favorites"
                                       name="favorites"
                                       value="1"
                                       {{ request()->has('favorites') ? 'checked' : '' }}
                                       onchange="$(this).closest('form').submit()"
                                >
                                <label class="custom-control-label" for="favorites">Favorite</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-3">
                            <input
                                type="text"
                                name="search[first_name]"
                                value="{{ request()->input('search.first_name') }}"
                                class="form-control"
                                onblur="$(this).closest('form').submit()"
                                placeholder="First name"
                            >
                        </div>
                        <div class="col-3">
                            <input
                                type="text"
                                name="search[last_name]"
                                value="{{ request()->input('search.last_name') }}"
                                class="form-control"
                                onblur="$(this).closest('form').submit()"
                                placeholder="Last name"
                            >
                        </div>
                        <div class="col-3">
                            <input
                                type="text"
                                name="search[middle_name]"
                                value="{{ request()->input('search.middle_name') }}"
                                class="form-control"
                                onblur="$(this).closest('form').submit()"
                                placeholder="Middle name"
                            >
                        </div>
                        <div class="col-3">
                            <input
                                type="text"
                                name="search[phone]"
                                value="{{ request()->input('search.phone') }}"
                                class="form-control"
                                onblur="$(this).closest('form').submit()"
                                placeholder="Phone"
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
                        <th></th>
                        <th scope="col">
                            <a href="{{ route('contacts.index', array_merge(request()->all(), [
                                'sort' => 'first_name',
                                'direction' => $sort == 'first_name' ? ($direction == 'desc' ? 'asc' : 'desc') : null,
                            ])) }}">First @if($sort == 'first_name') @if($direction == 'desc')↑@else↓@endif @endif</a>
                        </th>
                        <th scope="col">
                            <a href="{{ route('contacts.index', array_merge(request()->all(), [
                                'sort' => 'last_name',
                                'direction' => $sort == 'last_name' ? ($direction == 'desc' ? 'asc' : 'desc') : null
                            ])) }}">Last @if($sort == 'last_name') @if($direction == 'desc')↑@else↓@endif @endif</a>
                        </th>
                        <th scope="col">
                            <a href="{{ route('contacts.index', array_merge(request()->all(), [
                                'sort' => 'middle_name',
                                'direction' => $sort == 'middle_name' ? ($direction == 'desc' ? 'asc' : 'desc') : null
                            ])) }}">Middle @if($sort == 'middle_name') @if($direction == 'desc')↑@else↓@endif @endif</a>
                        </th>
                        <th scope="col">
                            <a href="{{ route('contacts.index', array_merge(request()->all(), [
                                'sort' => 'phone',
                                'direction' => $sort == 'phone' ? ($direction == 'desc' ? 'asc' : 'desc') : null
                             ])) }}">Phone @if($sort == 'phone') @if($direction == 'desc')↑@else↓@endif @endif</a>
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($contacts as $contact)
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="select-{{ $contact->id }}"
                                    name="select[]"
                                    value="{{ $contact->id }}"
                                >
                                <label class="custom-control-label cursor-pointer" for="select-{{ $contact->id }}"></label>
                            </div>
                        </td>
                        <td>
                            @if($contact->in_favorites)
                                <a href="{{ route('contacts.favorites.remove', $contact) }}"
                                   data-method="DELETE"
                                   class="btn btn-warning btn-sm favorites-action-link"
                                   data-toggle="tooltip"
                                   data-original-title="Remove from favorites">
                                    <i class="fa fa-star"></i>
                                </a>
                            @else
                                <a href="{{ route('contacts.favorites.add', $contact) }}"
                                   data-method="POST"
                                   class="btn btn-outline-secondary btn-sm favorites-action-link"
                                   data-toggle="tooltip"
                                   data-original-title="To favorites">
                                    <i class="fa fa-star-o"></i>
                                </a>
                            @endif
                        </td>
                        <td>{{ $contact->first_name }}</td>
                        <td>{{ $contact->last_name }}</td>
                        <td>{{ $contact->middle_name }}</td>
                        <td>{{ $contact->phone }}</td>
                        <td>
                            <div style="min-width: 120px">
                                <div class="float-right">
                                    @if($access_edit)
                                        <a href="{{ route('contacts.edit', $contact) }}"
                                           class="btn btn-outline-secondary btn-sm"
                                           data-toggle="tooltip"
                                           data-original-title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    @endif
                                    @if($access_delete)
                                        <a href="{{ route('contacts.delete', $contact) }}"
                                           data-method="DELETE"
                                           data-confirm="Confirm"
                                           class="btn btn-outline-secondary btn-sm"
                                           data-toggle="tooltip"
                                           data-original-title="Delete">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </form>
        </div>
        <div class="card-footer pt-4 pb-2">
            {{ $contacts->appends(request()->all())->links() }}
        </div>
    </div>
@endsection