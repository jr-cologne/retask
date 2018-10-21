<div class="btn-group">
    <a href="{{ route('task.edit', $task->id) }}" class="btn btn-warning">Edit</a>

    <form method="POST" action="{{ route('task.destroy', $task->id) }}" aria-label="{{ __('Delete Task') }}">
        @csrf

        <button type="submit" class="btn btn-danger">Delete</button>
        {{ method_field('DELETE') }}
    </form>
</div>
