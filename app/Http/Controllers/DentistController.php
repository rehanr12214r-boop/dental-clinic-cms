<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\ClinicContentService;
use App\Services\SlotAvailabilityService;
use Illuminate\Contracts\View\View;

class DentistController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private readonly ClinicContentService $content,
        private readonly SlotAvailabilityService $slotAvailability,
    ) {}

    /**
     * The clinic's care team.
     */
    public function index(): View
    {
        return view('dentists.index', [
            'dentists' => $this->content->dentists(),
        ]);
    }

    /**
     * A single dentist profile with clinic location and contact details.
     */
    public function show(string $slug): View
    {
        $dentist = $this->content->dentist($slug);

        abort_if($dentist === null, 404);

        return view('dentists.show', [
            'dentist' => $dentist,
            'clinicEmail' => Setting::get(Setting::ClinicEmail),
            'workingHours' => $this->slotAvailability->workingHoursSummary(),
        ]);
    }
}
