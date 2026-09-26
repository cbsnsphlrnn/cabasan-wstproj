<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Taskflow' }} | Taskflow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { ink: '#17212b', coral: '#e96b4b', mint: '#dff5ed', mist: '#f6f8f7' },
                    fontFamily: { display: ['Georgia', 'serif'], sans: ['Trebuchet MS', 'sans-serif'] }
                }
            }
        };
    </script>
</head>
<body class="min-h-screen bg-mist font-sans text-ink antialiased">
    <header class="border-b border-slate-200/80 bg-white/85 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-5 py-5 lg:px-8">
            <a href="{{ route('tasks.index') }}" class="flex items-center gap-3 text-lg font-bold tracking-tight">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-ink text-sm text-white">TM</span>
                TaskManager
            </a>
            <a href="{{ route('tasks.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-coral px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#d95d40] focus:outline-none focus:ring-2 focus:ring-coral focus:ring-offset-2">
                <span class="text-lg leading-none">+</span> New task
            </a>
        </div>
    </header>
    <main class="mx-auto max-w-6xl px-5 py-10 lg:px-8 lg:py-14">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800" role="status">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
                <p class="font-bold">Please check the form.</p>
                <ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>