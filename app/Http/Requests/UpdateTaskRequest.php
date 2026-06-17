<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //does user have access to the task
        $task = $this->route('task');
        return $this->user()->can('update', $task);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->user();

        // Если это исполнитель — ему разрешено присылать ТОЛЬКО статус
        if ($user->role === 'executor') {
            return [
                'status' => 'required|string|in:todo,in_progress,done', // укажите ваши статусы
            ];
        }

        // if its admin or manager, then all access
        if (in_array($user->role, ['admin', 'manager'])) {
            return [
                'title' => 'required|max:255',
                'description' => 'required',
                'status' => 'required',
                'priority' => 'required',
                'due_date' => 'required|date',
                'assignee_id' => 'required|exists:users,id',
            ];
        }

        return [];
    }
}
