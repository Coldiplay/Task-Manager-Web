<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;
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
