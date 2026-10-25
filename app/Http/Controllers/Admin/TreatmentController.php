<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Treatment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TreatmentController extends Controller
{
    /**
     * List all treatments with a quick activate/deactivate switch.
     */
    public function index(): View
    {
        $treatments = Treatment::query()
            ->withCount('appointments')
            ->orderBy('name')
            ->get();

        return view('admin.treatments.index', ['treatments' => $treatments]);
    }

    /**
     * Show the "new treatment" form.
     */
    public function create(): View
    {
        return view('admin.treatments.create', [
            'treatment' => new Treatment(['is_active' => true]),
        ]);
    }

    /**
     * Store a new treatment.
     */
    public function store(Request $request): RedirectResponse
    {
        Treatment::query()->create($this->validateTreatment($request));

        return redirect()
            ->route('admin.treatments.index')
            ->with('status', 'Treatment created.');
    }

    /**
     * Show the "edit treatment" form.
     */
    public function edit(Treatment $treatment): View
    {
        return view('admin.treatments.edit', ['treatment' => $treatment]);
    }

    /**
     * Update an existing treatment (fees, durations, name, active flag).
     */
    public function update(Request $request, Treatment $treatment): RedirectResponse
    {
        $treatment->update($this->validateTreatment($request, $treatment));

        return redirect()
            ->route('admin.treatments.index')
            ->with('status', "Treatment \"{$treatment->name}\" updated.");
    }

    /**
     * Toggle the active/inactive flag. Inactive treatments disappear from the
     * public booking portal but keep their historical appointments intact.
     */
    public function toggle(Treatment $treatment): RedirectResponse
    {
        $wasActive = $treatment->is_active;
        $treatment->update(['is_active' => ! $wasActive]);

        return back()->with('status', "\"{$treatment->name}\" was ".($wasActive ? 'deactivated' : 'activated').'.');
    }

    /**
     * Delete a treatment (only when it is not referenced by appointments).
     */
    public function destroy(Treatment $treatment): RedirectResponse
    {
        $bookingCount = $treatment->appointments()->count();

        if ($bookingCount > 0) {
            return back()->with(
                'error',
                "\"{$treatment->name}\" has {$bookingCount} appointment(s) on record and cannot be deleted — deactivate it instead."
            );
        }

        $treatment->delete();

        return redirect()
            ->route('admin.treatments.index')
            ->with('status', "Treatment \"{$treatment->name}\" deleted.");
    }

    /**
     * Shared validation for store/update.
     *
     * @return array<string, mixed>
     */
    protected function validateTreatment(Request $request, ?Treatment $treatment = null): array
    {
        $nameRules = ['required', 'string', 'max:255'];

        if ($treatment?->exists) {
            $nameRules[] = Rule::unique('treatments', 'name')->ignore($treatment);
        } else {
            $nameRules[] = Rule::unique('treatments', 'name');
        }

        $validated = $request->validate([
            'name' => $nameRules,
            'slug' => ['nullable', 'string', 'max:255'],
            'duration_minutes' => ['required', 'integer', 'min:5', 'max:480'],
            'cost' => ['required', 'numeric', 'min:0', 'max:999999'],
            'description' => ['nullable', 'string', 'max:2000'],
            'whats_included' => ['nullable', 'string', 'max:2000'],
            'pre_appointment_instructions' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $validated['duration_minutes'] = (int) $validated['duration_minutes'];
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');

        // Keep the public URL slug tidy and unique; empty values fall back to
        // the existing slug (or one generated from the name on create).
        if (filled($validated['slug'] ?? null)) {
            $validated['slug'] = Treatment::uniqueSlug($validated['slug'], $treatment);
        } else {
            unset($validated['slug']);
        }

        return $validated;
    }
}
