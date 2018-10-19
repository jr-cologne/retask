@extends('layouts.app')

@section('content')
    <h1>Hi, {{ $user->name }}!</h1>
    <h2>Here's your account dashboard:</h2>

    <div class="row justify-content-center mt-5">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('Your Account') }}</div>

                <div class="card-body">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item"><i class="fas fa-user"></i> <strong>Username:</strong> {{ $user->name }}</li>
                      <li class="list-group-item"><i class="fas fa-at"></i> <strong>Email:</strong> {{ $user->email }}</li>
                      <li class="list-group-item"><i class="fas fa-calendar"></i> <strong>Registration Date:</strong> {{ $user->created_at->format('F d, Y') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('Account Actions') }}</div>

                <div class="card-body">
                    <div class="btn-group" role="group" aria-label="Account Actions">
                        <a class="btn btn-danger" href="{{ route('account.delete') }}" role="button"><i class="fas fa-trash"></i> Delete account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
