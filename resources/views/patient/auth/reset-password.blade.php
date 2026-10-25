<x-layouts.public title="Choose a new password">

    <x-public.auth-shell
        compact
        title="Choose a new password"
        eyebrow="Almost there"
        subtitle="Use at least 8 characters with a letter, a number and a symbol."
    >
        <form method="POST" action="{{ route('patient.password.store') }}" class="space-y-5">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}"/>

            <div>
                <label for="email" class="field-label">Email address</label>
                <input id="email" type="email" name="email" required autocomplete="email"
                       value="{{ old('email', $email) }}"
                       placeholder="you@example.com"
                       class="field-input"/>
                @error('email')
                    <p class="mt-1.5 text-[11px] font-medium text-[#963f2b]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="field-label">New password</label>
                <input id="password" type="password" name="password" required autofocus autocomplete="new-password"
                       placeholder="At least 8 characters"
                       class="field-input"/>
                @error('password')
                    <p class="mt-1.5 text-[11px] font-medium text-[#963f2b]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="field-label">Confirm new password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       placeholder="Repeat your new password"
                       class="field-input"/>
            </div>

            <button type="submit" class="btn-medio w-full justify-center">
                Save new password
                <span class="btn-medio-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                    </svg>
                </span>
            </button>
        </form>
    </x-public.auth-shell>

</x-layouts.public>
