<x-layouts.admin
    title="Treatments"
    heading="Treatments management"
    headingSub="Services offered at the clinic, with fees and durations"
>
    <x-slot name="actions">
        <a href="{{ route('admin.treatments.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-cyan-700 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            New treatment
        </a>
    </x-slot>

    <div class="overflow-x-auto rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        <table class="w-full min-w-[48rem] text-left text-sm">
            <thead>
            <tr class="text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-4 py-3 font-semibold">Treatment</th>
                <th class="px-4 py-3 font-semibold">Duration</th>
                <th class="px-4 py-3 font-semibold">Fee</th>
                <th class="px-4 py-3 font-semibold">Bookings</th>
                <th class="px-4 py-3 font-semibold">Status</th>
                <th class="px-4 py-3 text-right font-semibold">Actions</th>
            </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
            @forelse ($treatments as $treatment)
                <tr class="transition hover:bg-slate-50/70">
                    <td class="px-4 py-3.5">
                        <p class="font-semibold text-slate-900">{{ $treatment->name }}</p>
                    </td>
                    <td class="px-4 py-3.5 text-slate-600">{{ $treatment->duration_minutes }} min</td>
                    <td class="px-4 py-3.5 font-medium text-slate-900">${{ number_format((float) $treatment->cost, 2) }}</td>
                    <td class="px-4 py-3.5 text-slate-600">{{ $treatment->appointments_count }}</td>

                    {{-- Active / inactive toggle --}}
                    <td class="px-4 py-3.5">
                        <form method="POST" action="{{ route('admin.treatments.toggle', $treatment) }}" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="inline-flex cursor-pointer items-center transition hover:opacity-80"
                                    title="{{ $treatment->is_active ? 'Deactivate (hide from public booking)' : 'Activate' }}">
                                <span class="relative inline-flex h-5 w-9 items-center rounded-full"
                                      @class(['bg-emerald-600' => $treatment->is_active, 'bg-slate-300' => ! $treatment->is_active])>
                                    <span class="absolute left-0.5 h-4 w-4 rounded-full bg-white shadow transition"
                                          @class(['translate-x-4' => $treatment->is_active, 'translate-x-0' => ! $treatment->is_active])></span>
                                </span>
                            </button>
                            <span class="text-xs font-semibold {{ $treatment->is_active ? 'text-emerald-700' : 'text-slate-400' }}">
                                {{ $treatment->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </form>
                    </td>

                    <td class="px-4 py-3.5">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.treatments.edit', $treatment) }}"
                               class="text-xs font-bold text-cyan-700 underline-offset-2 transition hover:underline">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.treatments.destroy', $treatment) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-xs font-bold text-rose-600 underline-offset-2 transition hover:underline">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-16 text-center">
                        <p class="text-4xl">🦷</p>
                        <p class="mt-3 font-semibold text-slate-900">No treatments yet</p>
                        <p class="mt-1 text-sm text-slate-500">Treatments power the public booking portal — add your first service with a fee and duration.</p>
                        <a href="{{ route('admin.treatments.create') }}"
                           class="mt-4 inline-flex rounded-xl bg-cyan-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600">
                            Add the first treatment
                        </a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</x-layouts.admin>
