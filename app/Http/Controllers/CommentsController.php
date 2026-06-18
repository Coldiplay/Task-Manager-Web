<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Models\Comment;
use App\Models\Task;

class CommentsController extends Controller
{
    public function index(Task $task)
    {
        $this->authorize('view-any', [Comment::class]);

        $comments = $task->comments;

        return view('comment.index', compact('comments', 'task'));
    }

    public function store(CreateCommentRequest $request, Task $task)
    {
        $task->comments()->create([
            'content' => $request->validated()['content'],
            'user_id' => $request->user()->id,
        ]);

        return back()->with('success', 'Комментарий успешно добавлен!');
    }


    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Комментарий успешно удален.');
    }
}
