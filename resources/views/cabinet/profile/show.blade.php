@extends('cabinet.profile.layout')

@section('profile-content')
    <div class="card">
        <h4 class="card-header">
            Profile
        </h4>
        <div class="card-body p-3">
            <div class="mb-3">
                <a href="{{ route('cabinet.profile.edit') }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('cabinet.profile.password.edit') }}" class="btn btn-primary">Change Password</a>
            </div>

            <table class="table table-bordered m-0">
                <tbody>
                <tr>
                    <th>Name</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Api token</th>
                    <td>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" value="{{ $user->api_token }}">
                            <form class="input-group-append"
                                  action="{{ route('cabinet.profile.token.refresh') }}"
                                  method="post">
                                @csrf @method('PUT')
                                <button class="btn btn-warning" type="submit"><i class="fa fa-refresh"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection