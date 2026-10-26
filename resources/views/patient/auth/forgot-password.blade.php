<x-layouts.public title="Reset your password">

    <x-public.auth-shell
        compact
        title="Forgot your password?"
        eyebrow="Password help"
        subtitle="Enter the email address on your patient account and we will send you a secure link to choose a new password. The link expires after 60 minutes."
    >
        <form method="POST" action="{{ route('patient.password.email') }}" class="space-y-5">
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

            <button type="submit" class="btn-medio w-full justify-center">
                Email me a reset link
                <span class="btn-medio-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                    </svg>
                </span>
            </button>
        </form>

        <x-slot:footer>
            Remembered it?
            <a href="{{ route('patient.login') }}" class="font-semibold text-terracotta underline-offset-2 hover:underline">Back to sign in</a>
        </x-slot:footer>

        <x-slot:note>
            For privacy, we never reveal whether an email address has an account.
        </x-slot:note>
    </x-public.auth-shell>

</x-layouts.public>
