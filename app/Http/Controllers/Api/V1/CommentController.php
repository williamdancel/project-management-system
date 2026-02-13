<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Comments\StoreCommentRequest;
use App\Models\Task;
use App\Services\V1\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(private CommentService $comments) {}

    public function index(Request $request, Task $task)
    {
        return response()->json(
            $this->comments->listForTask($task, $request->user())
        );
    }

    public function store(StoreCommentRequest $request, Task $task)
    {
        $comment = $this->comments->createForTask(
            $task,
            $request->user(),
            $request->validated()
        );

        return response()->json($comment, 201);
    }
}
