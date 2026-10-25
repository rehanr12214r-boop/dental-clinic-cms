<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dentist;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DentistController extends Controller
{
    /**
     * List all dentists.
     */
    public function index(): View
    {
        $dentists = Dentist::query()->orderBy('sort_order')->orderBy('name')->get();

        return view('admin.dentists.index', ['dentists' => $dentists]);
    }

    /**
     * Show the "new dentist" form.
     */
    public function create(): View
    {
        return view('admin.dentists.create', [
            'dentist' => new Dentist(['is_active' => true]),
        ]);
    }

    /**
     * Store a new dentist.
     */
    public function store(Request $request): RedirectResponse
    {
        Dentist::query()->create($this->validateDentist($request));

        return redirect()
            ->route('admin.dentists.index')
            ->with('status', 'Dentist profile created.');
    }

    /**
     * Show the "edit dentist" form.
     */
    public function edit(Dentist $dentist): View
    {
        return view('admin.dentists.edit', ['dentist' => $dentist]);
    }

    /**
     * Update an existing dentist.
     */
    public function update(Request $request, Dentist $dentist): RedirectResponse
    {
        $dentist->update($this->validateDentist($request, $dentist));

        return redirect()
            ->route('admin.dentists.index')
            ->with('status', "Dentist \"{$dentist->name}\" updated.");
    }

    /**
     * Toggle the active/inactive flag.
     */
    public function toggle(Dentist $dentist): RedirectResponse
    {
        $dentist->update(['is_active' => ! $dentist->is_active]);

        return back()->with('status', "\"{$dentist->name}\" ".($dentist->is_active ? 'activated' : 'deactivated').'.');
    }

    /**
     * Delete a dentist profile.
     */
    public function destroy(Dentist $dentist): RedirectResponse
    {
        $dentist->delete();

        return redirect()
            ->route('admin.dentists.index')
            ->with('status', "Dentist \"{$dentist->name}\" deleted.");
    }

    /**
     * Shared validation for store/update.
     *
     * @return array<string, mixed>
     */
    protected function validateDentist(Request $request, ?Dentist $dentist = null): array
    {
        $validated = $request->validate([
            'slug' => [
                'nullable', 'string', 'max:255',
                $dentist?->exists
                    ? Rule::unique('dentists', 'slug')->ignore($dentist)
                    : Rule::unique('dentists', 'slug'),
            ],
            'name' => ['required', 'string', 'max:255'],
            'short_name' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'experience' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'string', 'max:255'],
            'focus' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'education' => ['nullable', 'string', 'max:255'],
            'languages' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['short_name'] = $validated['short_name'] ?: $validated['name'];
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        return $validated;
    }
}
