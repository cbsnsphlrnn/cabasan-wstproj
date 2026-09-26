<div>
    <label for="task_name" class="mb-2 block text-sm font-bold">Task name</label>
    <input id="task_name" name="task_name" type="text" required maxlength="120" value="{{ old('task_name', $task->task_name ?? '') }}" placeholder="What needs doing?" class="w-full rounded-xl border-slate-200 bg-mist px-4 py-3 text-sm focus:border-coral focus:ring-coral">
</div>
<div>
    <label for="description" class="mb-2 block text-sm font-bold">Description <span class="font-normal text-slate-400">(optional)</span></label>
    <textarea id="description" name="description" rows="4" maxlength="1000" placeholder="Add a little context..." class="w-full rounded-xl border-slate-200 bg-mist px-4 py-3 text-sm focus:border-coral focus:ring-coral">{{ old('description', $task->description ?? '') }}</textarea>
</div>
<div class="grid gap-5 sm:grid-cols-2">
    <div>
        <label for="status" class="mb-2 block text-sm font-bold">Status</label>
        <select id="status" name="status" class="h-12 w-full rounded-xl border-slate-200 bg-mist px-4 text-sm focus:border-coral focus:ring-coral">
            @foreach (['Pending', 'Completed'] as $status)<option value="{{ $status }}" @selected(old('status', $task->status ?? 'Pending') === $status)>{{ $status }}</option>@endforeach
        </select>
    </div>
    <div>
        <label for="due_date" class="mb-2 block text-sm font-bold">Due date <span class="font-normal text-slate-400">(optional)</span></label>
        <input id="due_date" name="due_date" type="date" value="{{ old('due_date', isset($task) && $task->due_date ? $task->due_date->format('Y-m-d') : '') }}" class="h-12 w-full rounded-xl border-slate-200 bg-mist px-4 text-sm focus:border-coral focus:ring-coral">
    </div>
</div>
<div class="flex items-center justify-end gap-4 border-t border-slate-100 pt-5">
    <a href="{{ route('tasks.index') }}" class="text-sm font-bold text-slate-500 hover:text-ink">Cancel</a>
    <button type="submit" class="rounded-xl bg-ink px-5 py-3 text-sm font-bold text-white transition hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-ink focus:ring-offset-2">{{ $submitLabel }}</button>
</div>