<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 *
 * @package App
 */
class Task extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'task',
        'task_list_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function list()
    {
        return $this->belongsTo(TaskList::class, 'task_list_id');
    }
}
