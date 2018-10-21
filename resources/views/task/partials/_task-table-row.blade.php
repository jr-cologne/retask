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
        @include('task.partials._task-actions')
    </td>
</tr>
