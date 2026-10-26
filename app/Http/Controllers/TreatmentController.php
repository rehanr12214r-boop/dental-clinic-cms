<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use App\Services\SlotAvailabilityService;
use Illuminate\Contracts\View\View;

class TreatmentController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(private readonly SlotAvailabilityService $slotAvailability) {}

    /**
     * The public "all treatments" page with pricing, duration and detail links.
     */
    public function index(): View
    {
        return view('treatments.index', [
            'treatments' => Treatment::query()->active()->orderBy('cost')->get(),
            'workingHours' => $this->slotAvailability->workingHoursSummary(),
        ]);
    }

    /**
     * A single treatment's detail page: pricing, duration, what's included
     * and pre-appointment instructions.
     */
    public function show(Treatment $treatment): View
    {
        abort_unless($treatment->is_active, 404);

        return view('treatments.show', [
            'treatment' => $treatment,
            'relatedTreatments' => Treatment::query()
                ->active()
                ->whereKeyNot($treatment->getKey())
                ->orderBy('cost')
                ->limit(3)
                ->get(),
            'workingHours' => $this->slotAvailability->workingHoursSummary(),
        ]);
    }
}
