<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    //Status filter
    public function scopeByStatus(Builder $query, ?string $status): Builder
    {
        return $query->when($status, function ($q) use ($status) {
            $q->where('status', $status);
        });
    }

    //Priority filter
    public function scopeByPriority(Builder $query, ?string $priority): Builder
    {
        return $query->when($priority, function ($q) use ($priority) {
            $q->where('priority', $priority);
        });
    }

    //Filter by assignee
    public function scopeByAssignee(Builder $query, ?int $assigneeId): Builder
    {
        return $query->when($assigneeId, function ($q) use ($assigneeId) {
            $q->where('assignee_id', $assigneeId);
        });
    }

    public function scopeWithSorting(Builder $query, ?string $sortBy, ?string $direction = 'asc'): Builder
    {
        // Access for the sorting
        $allowedSortFields = ['created_at', 'priority', 'due_date'];

        // Direction (only asc or desc)
        //$direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';

        return $query->when(in_array($sortBy, $allowedSortFields), function ($q) use ($sortBy){//, $direction) {
            return $q->orderBy($sortBy);//, $direction);
        }, function ($q) {
            // Sort by default
            return $q->orderBy('created_at');//, 'desc');
        });
    }




    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        // task may have many comments
        return $this->hasMany(Comment::class)->latest(); // latest() sort from new to old
    }
}

//public function __construct(string $title, string $description, string $status, string $priority, ) : task
//{
//    $newTask = new task();
//    $newTask->title = $title;
//    $newTask->description = $description;
//    $newTask->status  = $status;
//
//
//    return $newTask;
//}
