@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('Create a new Task') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('tasks.store') }}" aria-label="{{ __('Create Task') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="task" class="col-sm-4 col-form-label text-md-right">{{ __('Task') }}</label>

                            <div class="col-md-6">
                                <input id="task" type="text" class="form-control{{ $errors->has('task') ? ' is-invalid' : '' }}" name="task" value="{{ old('task') }}" required autofocus>

                                @if ($errors->has('task'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('task') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create Task') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('Your Tasks') }}</div>

                <div class="card-body">
                    @if ($tasks->count())
                        <table class="table table-striped">
                            <thead>
                                <th>Task</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        <td>
                                            {{ $task->task }}
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" aria-label="{{ __('Delete Task') }}">
                                                @csrf

                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                {{ method_field('DELETE') }}
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>You do not have any tasks.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
