@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('Create a new Task') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('task.store') }}" aria-label="{{ __('Create Task') }}">
                        @csrf

                        <div class="form-group">
                            <label for="task">{{ __('Task') }}</label>
                            <input id="task" type="text" class="form-control{{ $errors->has('task') ? ' is-invalid' : '' }}" name="task" value="{{ old('task') }}" required autofocus>

                            @if ($errors->has('task'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('task') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="list">{{ __('List') }}</label>
                            <select id="list" class="form-control{{ $errors->has('list') ? ' is-invalid' : '' }}" name="list">
                                <option value="0">No list</option>

                                @if ($lists->count())
                                    @foreach ($lists as $list)
                                        <option value="{{ $list->id }}">{{ $list->name }}</option>
                                    @endforeach
                                @endif
                            </select>

                            @if ($errors->has('list'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('list') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Create Task') }}
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
                <div class="card-header">{{ __('Your Tasks') }}</div>

                <div class="card-body">
                    @if ($tasks->count())
                        <table class="table table-striped">
                            <thead>
                                <th>Task</th>
                                <th>List</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        <td>
                                            {{ $task->task }}
                                        </td>
                                        <td>
                                            @if (isset($task->list))
                                                <a href="{{ route('list.show', $task->list->id) }}">{{ $task->list->name }}</a>
                                            @else
                                                No list
                                            @endif
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('task.destroy', $task->id) }}" aria-label="{{ __('Delete Task') }}">
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
