<x-layouts.admin
    title="Dentists"
    heading="Dentists management"
    headingSub="The care team displayed on the public website"
>
    <x-slot name="actions">
        <a href="{{ route('admin.dentists.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-cyan-700 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            New dentist
        </a>
    </x-slot>

    <div class="overflow-x-auto rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        <table class="w-full min-w-[52rem] text-left text-sm">
            <thead>
            <tr class="text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-4 py-3 font-semibold">Name</th>
                <th class="px-4 py-3 font-semibold">Role</th>
                <th class="px-4 py-3 font-semibold">Experience</th>
                <th class="px-4 py-3 font-semibold">Order</th>
                <th class="px-4 py-3 font-semibold">Status</th>
                <th class="px-4 py-3 text-right font-semibold">Actions</th>
            </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
            @forelse ($dentists as $dentist)
                <tr class="transition hover:bg-slate-50/70">
                    <td class="px-4 py-3.5">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('images/site/'.$dentist->image) }}"
                                 alt="{{ $dentist->name }}"
                                 class="size-10 rounded-full object-cover object-top">
                            <div>
                                <p class="font-semibold text-slate-900">{{ $dentist->name }}</p>
                                <p class="text-xs text-slate-400">{{ $dentist->slug }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3.5 text-slate-600">{{ $dentist->role }}</td>
                    <td class="px-4 py-3.5 text-slate-600">{{ $dentist->experience }}</td>
                    <td class="px-4 py-3.5 text-slate-600">{{ $dentist->sort_order }}</td>

                    {{-- Active / inactive toggle --}}
                    <td class="px-4 py-3.5">
                        <form method="POST" action="{{ route('admin.dentists.toggle', $dentist) }}" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="inline-flex cursor-pointer items-center transition hover:opacity-80"
                                    title="{{ $dentist->is_active ? 'Deactivate' : 'Activate' }}">
                                <span class="relative inline-flex h-5 w-9 items-center rounded-full"
                                      @class(['bg-emerald-600' => $dentist->is_active, 'bg-slate-300' => ! $dentist->is_active])>
                                    <span class="absolute left-0.5 h-4 w-4 rounded-full bg-white shadow transition"
                                          @class(['translate-x-4' => $dentist->is_active, 'translate-x-0' => ! $dentist->is_active])></span>
                                </span>
                            </button>
                            <span class="text-xs font-semibold {{ $dentist->is_active ? 'text-emerald-700' : 'text-slate-400' }}">
                                {{ $dentist->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </form>
                    </td>

                    <td class="px-4 py-3.5">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.dentists.edit', $dentist) }}"
                               class="text-xs font-bold text-cyan-700 underline-offset-2 transition hover:underline">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.dentists.destroy', $dentist) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Delete {{ addslashes($dentist->name) }}?')"
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
                        <p class="text-4xl">👨‍⚕️</p>
                        <p class="mt-3 font-semibold text-slate-900">No dentists yet</p>
                        <p class="mt-1 text-sm text-slate-500">Add your first team member to display them on the public website.</p>
                        <a href="{{ route('admin.dentists.create') }}"
                           class="mt-4 inline-flex rounded-xl bg-cyan-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600">
                            Add first dentist
                        </a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</x-layouts.admin>
