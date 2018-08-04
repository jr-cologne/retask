@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('Create a new List') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('list.store') }}" aria-label="{{ __('Create List') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name">{{ __('List') }}</label>
                            <input id="name" type="text" class="form-control{{ $errors->has('list') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Create List') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('Your Lists') }}</div>

                <div class="card-body">
                    @if ($lists->count())
                        <table class="table table-striped">
                            <thead>
                                <th>List</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($lists as $list)
                                    <tr>
                                        <td>
                                            <a href="{{ route('list.show', $list->id) }}">{{ $list->name }}</a>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('list.destroy', $list->id) }}" aria-label="{{ __('Delete List') }}" class="d-flex align-items-center">
                                                {{ method_field('DELETE') }}
                                                @csrf

                                                <button type="submit" class="btn btn-danger">Delete</button>

                                                <div class="form-check ml-3">
                                                    <input type="checkbox" name="delete_tasks" value="true" id="delete_tasks" class="form-check-input">
                                                    <label for="delete_tasks" class="form-check-label">Also delete tasks</label>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>You do not have any lists.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
