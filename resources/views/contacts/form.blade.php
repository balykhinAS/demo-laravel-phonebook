@extends('layouts.wrap')

@section('wrap-content')
    <div class="page-header clearfix mb-3">
        <h1 class="page-title pull-left">Contacts</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>@endif
    @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
    @endif

    <form method="POST" action="{{ $contact->id ? route('contacts.update', $contact) : route('contacts.store') }}">
        @csrf
        @if($contact->id) @method('PUT') @endif

        <div class="card">
            <h4 class="card-header">
                {{ $contact->id ? 'Edit' : 'Create'}} contact
                <a href="{{ route('contacts.index') }}" class="btn btn-link">Back</a>
            </h4>

            <div class="card-body p-3">

                <div class="row">
                    <div class="col-md-9 offset-md-1">
                        <div class="form-group row">
                            <label for="first_name" class="col-md-3 col-form-label">First name</label>
                            <div class="col-md-9">
                                <input
                                    id="first_name"
                                    class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                    name="first_name"
                                    value="{{ old('first_name', $contact->first_name) }}"
                                    required
                                >
                                @if ($errors->has('first_name'))
                                    <span class="invalid-feedback"><strong>{{ $errors->first('first_name') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="last_name" class="col-md-3 col-form-label">Last name</label>
                            <div class="col-md-9">
                                <input
                                    id="last_name"
                                    class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                    name="last_name"
                                    value="{{ old('last_name', $contact->last_name) }}"
                                    required
                                >
                                @if ($errors->has('last_name'))
                                    <span class="invalid-feedback"><strong>{{ $errors->first('last_name') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="middle_name" class="col-md-3 col-form-label">Middle name</label>
                            <div class="col-md-9">
                                <input
                                    id="middle_name"
                                    class="form-control{{ $errors->has('middle_name') ? ' is-invalid' : '' }}"
                                    name="middle_name"
                                    value="{{ old('middle_name', $contact->middle_name) }}"
                                    required
                                >
                                @if ($errors->has('middle_name'))
                                    <span class="invalid-feedback"><strong>{{ $errors->first('middle_name') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-3 col-form-label">Phone number</label>
                            <div class="col-md-9">
                                <input
                                    id="phone"
                                    class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                    name="phone"
                                    value="{{ old('phone', $contact->phone) }}"
                                    required
                                >
                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback"><strong>{{ $errors->first('phone') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Created</label>
                            <div class="col-md-9">
                                <input class="form-control" value="{{ $contact->created_at  }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Updated</label>
                            <div class="col-md-9">
                                <input class="form-control" value="{{ $contact->updated_at  }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">{{ $contact->id ? 'Save' : 'Add'}}</button>
            </div>
        </div>
    </form>
@endsection