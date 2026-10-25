<x-layouts.public title="Patient sign in">

    <x-public.auth-shell
        title="Welcome back"
        eyebrow="Patient portal"
        subtitle="Sign in to see your upcoming visits, treatment history and printable receipts."
        image="appointment-hero.jpg"
        quote="Care that remembers you."
    >
        <form method="POST" action="{{ route('patient.login.authenticate') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="field-label">Email address</label>
                <input id="email" type="email" name="email" required autofocus autocomplete="email"
                       value="{{ old('email') }}"
                       placeholder="you@example.com"
                       class="field-input"/>
                @error('email')
                    <p class="mt-1.5 text-[11px] font-medium text-[#963f2b]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="field-label">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       placeholder="Your password"
                       class="field-input"/>
                @error('password')
                    <p class="mt-1.5 text-[11px] font-medium text-[#963f2b]">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between gap-3">
                <label class="flex items-center gap-2.5">
                    <input type="checkbox" name="remember" value="1"
                           class="size-4 rounded border-line accent-[#c2714d]"/>
                    <span class="text-[12px] font-medium text-body">Keep me signed in</span>
                </label>
                <a href="{{ route('patient.password.request') }}" class="text-[11px] font-semibold text-terracotta underline-offset-2 hover:underline">
                    Forgot your password?
                </a>
            </div>

            <button type="submit" class="btn-medio w-full justify-center">
                Sign in
                <span class="btn-medio-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                    </svg>
                </span>
            </button>
        </form>

        <x-slot:footer>
            New patient?
            <a href="{{ route('patient.register') }}" class="font-semibold text-terracotta underline-offset-2 hover:underline">Create an account</a>
        </x-slot:footer>

        <x-slot:note>
            Booked as a guest? You can
            <a href="{{ route('appointment.lookup') }}" class="font-semibold text-ink underline-offset-2 hover:underline">track your booking</a>
            without an account — or sign up with the same phone number to link your visits automatically.
        </x-slot:note>
    </x-public.auth-shell>

</x-layouts.public>
