@extends('layouts.app', ['title' => 'Your tasks'])

@section('content')
<section class="mb-10 flex flex-col justify-between gap-6 md:flex-row md:items-end">
    <div>
        <p class="mb-3 text-xs font-bold uppercase tracking-[0.24em] text-coral">Personal Task Manager</p>
        <h1 class="font-display text-4xl leading-tight text-ink sm:text-5xl">Take a look to<br><span class="text-coral">what matters.</span></h1>
        
    </div>
    <div class="grid grid-cols-3 gap-2 sm:gap-3">
        <div class="min-w-[82px] rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200/70"><p class="text-2xl font-bold">{{ $totalTasks }}</p><p class="mt-1 text-xs text-slate-500">All tasks</p></div>
        <div class="min-w-[82px] rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200/70"><p class="text-2xl font-bold text-coral">{{ $pendingTasks }}</p><p class="mt-1 text-xs text-slate-500">Pending</p></div>
        <div class="min-w-[82px] rounded-2xl bg-mint p-4 shadow-sm"><p class="text-2xl font-bold text-emerald-800">{{ $completedTasks }}</p><p class="mt-1 text-xs text-emerald-700">Completed</p></div>
    </div>
</section>

<div class="mb-5 flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 pb-4">
    <div class="flex gap-1 rounded-xl bg-slate-200/70 p-1 text-sm font-bold">
        <a href="{{ route('tasks.index') }}" class="rounded-lg px-3 py-2 {{ !$activeStatus ? 'bg-white text-ink shadow-sm' : 'text-slate-500' }}">All</a>
        <a href="{{ route('tasks.index', ['status' => 'Pending']) }}" class="rounded-lg px-3 py-2 {{ $activeStatus === 'Pending' ? 'bg-white text-ink shadow-sm' : 'text-slate-500' }}">Pending</a>
        <a href="{{ route('tasks.index', ['status' => 'Completed']) }}" class="rounded-lg px-3 py-2 {{ $activeStatus === 'Completed' ? 'bg-white text-ink shadow-sm' : 'text-slate-500' }}">Completed</a>
    </div>
    <span class="text-sm text-slate-400">{{ $tasks->count() }} {{ $tasks->count() === 1 ? 'task' : 'tasks' }}</span>
</div>

@if ($tasks->isEmpty())
    <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
        <div class="mx-auto mb-4 grid h-12 w-12 place-items-center rounded-full bg-mint text-xl text-emerald-700">✓</div>
        <h2 class="font-display text-2xl">Nothing here yet.</h2>
        <p class="mx-auto mt-2 max-w-sm text-sm text-slate-500">Add a task to start turning a busy mind into a clear plan.</p>
        <a href="{{ route('tasks.create') }}" class="mt-6 inline-flex rounded-xl bg-ink px-4 py-2.5 text-sm font-bold text-white hover:bg-slate-700">Create your first task</a>
    </div>
@else
    <div class="space-y-3">
        @foreach ($tasks as $task)
            <article class="group flex flex-col gap-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200/70 transition hover:shadow-md sm:flex-row sm:items-center sm:justify-between">
                <div class="flex min-w-0 flex-1 items-start gap-4">
                    <form method="POST" action="{{ route('tasks.status', $task) }}" class="shrink-0">@csrf @method('PATCH')
                        <button type="submit" aria-label="Mark task {{ $task->status === 'Completed' ? 'pending' : 'completed' }}" class="mt-1 grid h-6 w-6 place-items-center rounded-full border-2 {{ $task->status === 'Completed' ? 'border-emerald-500 bg-emerald-500 text-white' : 'border-slate-300 text-transparent hover:border-coral' }}">✓</button>
                    </form>
                    <div class="min-w-0">
                        <h2 class="truncate font-bold {{ $task->status === 'Completed' ? 'text-slate-400 line-through' : 'text-ink' }}">{{ $task->task_name }}</h2>
                        @if ($task->description)<p class="mt-1 line-clamp-2 text-sm text-slate-500">{{ $task->description }}</p>@endif
                        <div class="mt-3 flex flex-wrap items-center gap-3 text-xs font-semibold text-slate-400">
                            <span class="rounded-full px-2.5 py-1 {{ $task->status === 'Completed' ? 'bg-mint text-emerald-700' : 'bg-orange-50 text-coral' }}">{{ $task->status }}</span>
                            @if ($task->due_date)<span>Due {{ $task->due_date->format('M j, Y') }}</span>@endif
                        </div>
                    </div>
                </div>
                <div class="flex shrink-0 items-center gap-3 pl-10 sm:pl-0">
                    <a href="{{ route('tasks.edit', $task) }}" class="text-sm font-bold text-slate-500 hover:text-ink">Edit</a>
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')">@csrf @method('DELETE')<button type="submit" class="text-sm font-bold text-red-400 hover:text-red-600">Delete</button></form>
                </div>
            </article>
        @endforeach
    </div>
@endif
@endsection