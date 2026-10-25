<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
        use App\Models\Setting;

        $clinicName = Setting::get(Setting::ClinicName);
    @endphp

    <title>Sign in · {{ $clinicName }} Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="grid min-h-full place-items-center bg-slate-900 px-4 py-12 font-sans text-slate-900 antialiased">

<div class="w-full max-w-md">
    <div class="mb-8 text-center">
        <span class="inline-grid size-14 place-items-center rounded-2xl bg-linear-to-br from-sky-600 to-teal-500 text-2xl shadow-lg ring-1 ring-white/20">🦷</span>
        <h1 class="mt-4 text-xl font-bold tracking-tight text-white">{{ $clinicName }}</h1>
        <p class="mt-1 text-sm text-slate-400">Sign in to manage appointments, schedule and treatments</p>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-2xl sm:p-8">
        @if ($errors->any())
            <div class="mb-5 rounded-xl bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700 ring-1 ring-rose-600/20">
                <ul class="list-inside list-disc space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.authenticate') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                       placeholder="admin@clinic.com"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 transition focus:border-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-600/20">
            </div>

            <div>
                <label for="password" class="mb-1.5 block text-sm font-semibold text-slate-700">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       placeholder="••••••••"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 transition focus:border-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-600/20">
            </div>

            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember" value="1"
                       class="size-4 rounded border-slate-300 text-cyan-600 focus:ring-cyan-600/30">
                Remember me
            </label>

            <button type="submit"
                    class="w-full rounded-xl bg-cyan-700 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-700">
                Sign in
            </button>
        </form>
    </div>

    <p class="mt-6 text-center text-xs text-slate-500">
        <a href="{{ route('home') }}" class="font-medium text-slate-400 underline-offset-2 transition hover:text-white hover:underline">← Back to the public booking portal</a>
    </p>
</div>

</body>
</html>
