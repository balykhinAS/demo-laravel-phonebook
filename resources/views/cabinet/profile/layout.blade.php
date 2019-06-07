@extends('layouts.wrap')

@section('wrap-content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="page-header clearfix mb-3">
                <h1>{{ Auth::user()->name }}</h1>
            </div>

            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">Updated</div>@endif
            @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
            @endif
            @yield('profile-content')
        </div>
    </div>
@endsection