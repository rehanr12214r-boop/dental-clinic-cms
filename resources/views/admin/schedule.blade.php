<x-layouts.admin
    title="Doctor Schedule"
    heading="Doctor schedule management"
    headingSub="Working days, hours and slot duration for the public booking portal"
>

    <form method="POST" action="{{ route('admin.schedule.update') }}">
        @csrf
        @method('PUT')

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($weekdays as ['day' => $day, 'label' => $label])
                @php
                    $schedule = $schedules->get($day);
                    $isDayOff = $schedule?->is_day_off ?? false;
                @endphp

                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 {{ $isDayOff ? 'opacity-80' : '' }}">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">{{ $label }}</h3>
                            <p class="mt-0.5 text-xs text-slate-500">
                                @if ($isDayOff)
                                    Day off — not bookable
                                @else
                                    {{ \Carbon\CarbonImmutable::parse($schedule?->start_time ?? '17:00')->format('g:i A') }}
                                    –
                                    {{ \Carbon\CarbonImmutable::parse($schedule?->end_time ?? '21:00')->format('g:i A') }}
                                    · {{ $schedule?->slot_duration_minutes ?? 30 }}-min slots
                                @endif
                            </p>
                        </div>

                        {{-- Day-off toggle switch --}}
                        <label class="inline-flex cursor-pointer items-center gap-2">
                            <input type="checkbox" name="schedules[{{ $day }}][is_day_off]" value="1"
                                   @checked(old('schedules.'.$day.'.is_day_off', $isDayOff))
                                   class="peer sr-only">
                            <span class="relative inline-flex h-5 w-9 shrink-0 items-center rounded-full bg-slate-300 transition-colors duration-200 peer-checked:bg-emerald-600 peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-cyan-700 after:absolute after:left-0.5 after:top-0.5 after:h-4 after:w-4 after:translate-x-0 after:rounded-full after:bg-white after:shadow after:transition-transform after:duration-200 peer-checked:after:translate-x-4"></span>
                            <span class="text-xs font-semibold text-slate-600 transition-colors peer-checked:text-emerald-700">Day off</span>
                        </label>
                    </div>

                    <div class="mt-4 grid grid-cols-3 gap-2">
                        <div>
                            <label for="start-{{ $day }}" class="mb-1 block text-[11px] font-semibold uppercase tracking-wide text-slate-500">Start</label>
                            <input id="start-{{ $day }}" type="time" step="300"
                                   name="schedules[{{ $day }}][start_time]"
                                   value="{{ old('schedules.'.$day.'.start_time', $schedule?->start_time ?? '17:00') }}"
                                   class="w-full rounded-lg border border-slate-300 bg-white px-2 py-2 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                        </div>
                        <div>
                            <label for="end-{{ $day }}" class="mb-1 block text-[11px] font-semibold uppercase tracking-wide text-slate-500">End</label>
                            <input id="end-{{ $day }}" type="time" step="300"
                                   name="schedules[{{ $day }}][end_time]"
                                   value="{{ old('schedules.'.$day.'.end_time', $schedule?->end_time ?? '21:00') }}"
                                   class="w-full rounded-lg border border-slate-300 bg-white px-2 py-2 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                        </div>
                        <div>
                            <label for="slot-{{ $day }}" class="mb-1 block text-[11px] font-semibold uppercase tracking-wide text-slate-500">Slot</label>
                            <select id="slot-{{ $day }}" name="schedules[{{ $day }}][slot_duration_minutes]"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-2 py-2 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                                @foreach ($slotOptions as $option)
                                    <option value="{{ $option }}" @selected(old('schedules.'.$day.'.slot_duration_minutes', $schedule?->slot_duration_minutes ?? 30) == $option)>
                                        {{ $option }} min
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex items-center gap-3">
            <button type="submit"
                    class="rounded-xl bg-cyan-700 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-700">
                Save schedule
            </button>
            <p class="text-xs text-slate-500">Changes apply immediately to the public booking portal's available slots.</p>
        </div>
    </form>

</x-layouts.admin>
