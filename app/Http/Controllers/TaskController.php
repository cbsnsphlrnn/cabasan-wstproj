<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $tasks = Task::query()
            ->when(in_array($status, ['Pending', 'Completed'], true), fn ($query) => $query->where('status', $status))
            ->orderByRaw("CASE WHEN status = 'Pending' THEN 0 ELSE 1 END")
            ->orderBy('due_date')
            ->latest()
            ->get();

        return view('tasks.index', [
            'tasks' => $tasks,
            'activeStatus' => $status,
            'totalTasks' => Task::count(),
            'pendingTasks' => Task::where('status', 'Pending')->count(),
            'completedTasks' => Task::where('status', 'Completed')->count(),
        ]);
    }

    public function create(): View
    {
        return view('tasks.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Task::create($this->validatedData($request));

        return to_route('tasks.index')->with('success', 'Task added to your list.');
    }

    public function edit(Task $task): View
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $task->update($this->validatedData($request));

        return to_route('tasks.index')->with('success', 'Task details updated.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return to_route('tasks.index')->with('success', 'Task removed.');
    }

    public function updateStatus(Task $task): RedirectResponse
    {
        $task->update([
            'status' => $task->status === 'Completed' ? 'Pending' : 'Completed',
        ]);

        return to_route('tasks.index')->with('success', 'Task status updated.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'task_name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:Pending,Completed'],
            'due_date' => ['nullable', 'date'],
        ]);
    }
}