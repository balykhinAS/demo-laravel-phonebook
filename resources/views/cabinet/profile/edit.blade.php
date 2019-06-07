@extends('cabinet.profile.layout')

@section('profile-content')
    <form method="POST" action="{{ route('cabinet.profile.update') }}">
        @csrf
        @method('PUT')

        <div class="card">
            <h4 class="card-header">
                Update profile
            </h4>

            <div class="card-body p-3">
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
            </div>

            <div class="card-footer">
                <a href="{{ route('cabinet.profile.show') }}" class="btn btn-link">Back</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
@endsection