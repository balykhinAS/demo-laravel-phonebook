@extends('layouts.wrap')

@section('wrap-content')
    <div class="page-header clearfix mb-3">
        <h1 class="page-title pull-left">Users</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>@endif
    @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
    @endif

    <form method="POST" action="{{ $user->id ? route('users.update', $user) : route('users.store') }}">
        @csrf
        @if($user->id) @method('PUT') @endif

        <div class="card">
            <h4 class="card-header">
               {{ $user->id ? 'Edit' : 'Create'}} user
                <a href="{{ route('users.index') }}" class="btn btn-link">Back</a>
            </h4>

            <div class="card-body p-3">

                <div class="row">
                    <div class="col-md-9 offset-md-1">
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label">Name</label>
                            <div class="col-md-9">
                                <input
                                    id="name"
                                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    name="name"
                                    value="{{ old('name', $user->name) }}"
                                    required
                                >
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label">Email</label>
                            <div class="col-md-9">
                                <input
                                    id="email"
                                    class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    required
                                >
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback"><strong>{{ $errors->first('email') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <div class="row mt-4">
                            @foreach($permissions as $permission)
                                <div class="col col-md-4 mb-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox"
                                               class="custom-control-input"
                                               id="{{ $permission }}"
                                               name="permissions[]"
                                               value="{{ $permission }}"
                                               {{ $user->hasPermission($permission) ? 'checked' : '' }}
                                        >
                                        <label class="custom-control-label h4" for="{{ $permission }}">{{ $permission }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Created</label>
                            <div class="col-md-9">
                                <input class="form-control" value="{{ $user->created_at  }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Updated</label>
                            <div class="col-md-9">
                                <input class="form-control" value="{{ $user->updated_at  }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">{{ $user->id ? 'Save' : 'Add'}}</button>
            </div>
        </div>
    </form>
@endsection