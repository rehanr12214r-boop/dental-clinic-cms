<x-layouts.public title="Create a patient account">

    <x-public.auth-shell
        title="Create your patient account"
        eyebrow="Join the portal"
        subtitle="Track upcoming visits, view treatment history, download receipts and manage bookings — all in one place. Signing up is free and takes a minute."
        image="benefits-smile.jpg"
        quote="A calmer way to stay on top of your care."
    >
        <form method="POST" action="{{ route('patient.register.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="field-label">Full name</label>
                <input id="name" type="text" name="name" required autofocus autocomplete="name"
                       value="{{ old('name') }}"
                       placeholder="e.g. Saima Ali"
                       class="field-input"/>
                @error('name')
                    <p class="mt-1.5 text-[11px] font-medium text-[#963f2b]">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="email" class="field-label">Email address</label>
                    <input id="email" type="email" name="email" required autocomplete="email"
                           value="{{ old('email') }}"
                           placeholder="you@example.com"
                           class="field-input"/>
                    @error('email')
                        <p class="mt-1.5 text-[11px] font-medium text-[#963f2b]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="field-label">WhatsApp number</label>
                    <input id="phone" type="tel" name="phone" required autocomplete="tel" inputmode="tel"
                           value="{{ old('phone') }}"
                           placeholder="+964 770 123 4567"
                           class="field-input"/>
                    @error('phone')
                        <p class="mt-1.5 text-[11px] font-medium text-[#963f2b]">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="sm:max-w-[10rem]">
                <label for="age" class="field-label">Age <span class="normal-case tracking-normal text-muted">(optional)</span></label>
                <input id="age" type="number" name="age" min="1" max="120" inputmode="numeric"
                       value="{{ old('age') }}"
                       placeholder="e.g. 32"
                       class="field-input"/>
                @error('age')
                    <p class="mt-1.5 text-[11px] font-medium text-[#963f2b]">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="password" class="field-label">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           placeholder="8+ chars, number &amp; symbol"
                           class="field-input"/>
                    @error('password')
                        <p class="mt-1.5 text-[11px] font-medium text-[#963f2b]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="field-label">Confirm password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           placeholder="Repeat your password"
                           class="field-input"/>
                </div>
            </div>

            <button type="submit" class="btn-medio w-full justify-center">
                Create my account
                <span class="btn-medio-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                    </svg>
                </span>
            </button>
        </form>

        <x-slot:footer>
            Already have an account?
            <a href="{{ route('patient.login') }}" class="font-semibold text-terracotta underline-offset-2 hover:underline">Sign in</a>
        </x-slot:footer>

        <x-slot:note>
            Already booked as a guest? Use the same WhatsApp number when signing up and your previous
            visits are linked to your account automatically.
        </x-slot:note>
    </x-public.auth-shell>

</x-layouts.public>
