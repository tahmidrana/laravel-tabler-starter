@extends('layouts.app')


@section('content')

<div class="row justify-content-center">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Profile</h3>
            </div>
            <form action="{{ route('profile.edit') }}" method="POST" novalidate>
                @csrf
                @method('patch')
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Name *</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email <small>(can't be changed)</small></label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required readonly />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="last_login" class="form-label">Last Login</label>
                                <input type="text" name="" id="last_login" class="form-control" value="{{ $user->last_login }}" readonly />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <input type="submit" name="save" id="save" class="btn btn-primary" value="Save">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection
