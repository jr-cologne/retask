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
                                            @include('task.partials._task-actions')
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
