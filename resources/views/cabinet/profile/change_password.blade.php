@extends('cabinet.profile.layout')

@section('profile-content')
    <form method="POST" action="{{ route('cabinet.profile.password.update') }}">
        @csrf
        @method('PUT')

        <div class="card">
            <h4 class="card-header">
                Change password
            </h4>

            <div class="card-body p-3">
                <div class="form-group row">
                    <label for="current_password" class="col-md-3 col-form-label">Current password</label>
                    <div class="col-md-9">
                        <input
                            id="current_password"
                            class="form-control{{ $errors->has('current_password') ? ' is-invalid' : '' }}"
                            name="current_password"
                            value=""
                            required
                        >
                        @if ($errors->has('current_password'))
                            <span class="invalid-feedback"><strong>{{ $errors->first('current_password') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-3 col-form-label">New password</label>
                    <div class="col-md-9">
                        <input
                            id="password"
                            class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                            name="password"
                            value=""
                            required
                        >
                        @if ($errors->has('password'))
                            <span class="invalid-feedback"><strong>{{ $errors->first('password') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password_confirmation" class="col-md-3 col-form-label">Confirm password</label>
                    <div class="col-md-9">
                        <input id="password_confirmation" class="form-control" name="password_confirmation" value="" required>
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