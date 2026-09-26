@extends('layouts.app', ['title' => 'New task'])

@section('content')
<div class="mx-auto max-w-2xl">
    <a href="{{ route('tasks.index') }}" class="text-sm font-bold text-slate-500 hover:text-ink">← Back to tasks</a>
    <div class="mt-6 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70 sm:p-8">
        <p class="text-xs font-bold uppercase tracking-[0.24em] text-coral">Add new task to work</p>
        <h1 class="mt-2 font-display text-4xl">Create a task</h1>
        <form method="POST" action="{{ route('tasks.store') }}" class="mt-8 space-y-5">@csrf @include('tasks.form', ['submitLabel' => 'Add task'])</form>
    </div>
</div>
@endsection