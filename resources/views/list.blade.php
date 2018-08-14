@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('List') }} - {{ $list->name }}</div>

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
                        <p>You do not have any tasks in this list.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
