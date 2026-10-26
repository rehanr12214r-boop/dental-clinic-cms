<?php

namespace Database\Seeders;

use App\Models\Treatment;
use Illuminate\Database\Seeder;

class TreatmentSeeder extends Seeder
{
    /**
     * Seed the default dental treatments offered by the clinic, including the
     * public-site copy shown on the landing page and treatment detail pages.
     */
    public function run(): void
    {
        $treatments = [
            [
                'name' => 'Teeth Cleaning',
                'slug' => 'teeth-cleaning',
                'duration_minutes' => 30,
                'cost' => 50.00,
                'is_featured' => true,
                'description' => 'A gentle professional clean that removes plaque and tartar, polishes the enamel and leaves your mouth feeling fresh. The fastest way to protect your gums and prevent cavities.',
                'whats_included' => "Full oral examination\nUltrasonic removal of plaque and tartar\nPolish and fluoride treatment\nPersonalised home-care advice",
                'pre_appointment_instructions' => "Eat normally before your visit — cleaning is painless.\nSkip very hot or cold drinks an hour before your appointment.\nBring a list of any medications you take.",
            ],
            [
                'name' => 'Root Canal',
                'slug' => 'root-canal',
                'duration_minutes' => 90,
                'cost' => 300.00,
                'is_featured' => true,
                'description' => 'Save an infected or badly damaged tooth with modern, virtually painless endodontic treatment. We clean and seal the inside of the tooth to stop the pain and keep your natural smile.',
                'whats_included' => "Digital X-ray and diagnosis\nLocal anaesthesia for total comfort\nCleaning and sealing of the root canals\nTemporary filling and a follow-up check",
                'pre_appointment_instructions' => "Eat a light meal before the appointment — you will not be able to chew comfortably for a few hours afterwards.\nPlan for 60–90 minutes in the chair.\nTake your usual pain relief if the tooth is sore; tell us what you took.",
            ],
            [
                'name' => 'General Checkup',
                'slug' => 'general-checkup',
                'duration_minutes' => 30,
                'cost' => 40.00,
                'is_featured' => false,
                'description' => 'A thorough examination of your teeth, gums and bite. Ideal for first visits and six-monthly check-ups, with a clear written treatment plan and honest pricing.',
                'whats_included' => "Complete oral examination\nX-ray when clinically needed\nWritten treatment plan with costs\nOral hygiene and prevention advice",
                'pre_appointment_instructions' => "Arrive about 10 minutes early for registration.\nBring details of any recent dental work or x-rays.\nList any medications or allergies for the doctor.",
            ],
            [
                'name' => 'Tooth Extraction',
                'slug' => 'tooth-extraction',
                'duration_minutes' => 45,
                'cost' => 120.00,
                'is_featured' => true,
                'description' => 'Safe, comfortable removal of a tooth that cannot be saved — including wisdom teeth. You leave with clear aftercare instructions and a follow-up plan to restore the gap.',
                'whats_included' => "X-ray and pre-extraction assessment\nLocal anaesthesia\nGentle extraction by an experienced dentist\nAftercare kit and written aftercare advice",
                'pre_appointment_instructions' => "Eat something before the appointment — no snacks afterwards for a few hours.\nNo smoking for 24 hours before your visit.\nArrange a ride home if the extraction may be surgical.",
            ],
            [
                'name' => 'Braces Consultation',
                'slug' => 'braces-consultation',
                'duration_minutes' => 30,
                'cost' => 60.00,
                'is_featured' => true,
                'description' => 'Thinking about straightening your teeth? Get a full assessment, honest expectations and a clear plan — including treatment time and monthly payment options.',
                'whats_included' => "Orthodontic assessment and photos\nDiscussion of braces vs clear aligners\nEstimated treatment timeline\nFlexible payment plan options",
                'pre_appointment_instructions' => "Write down the questions you want to ask the doctor.\nBring any previous x-rays or dental records if you have them.\nNo special preparation needed.",
            ],
        ];

        foreach ($treatments as $treatment) {
            Treatment::query()->updateOrCreate(
                ['name' => $treatment['name']],
                [
                    'slug' => $treatment['slug'],
                    'duration_minutes' => $treatment['duration_minutes'],
                    'cost' => $treatment['cost'],
                    'description' => $treatment['description'],
                    'whats_included' => $treatment['whats_included'],
                    'pre_appointment_instructions' => $treatment['pre_appointment_instructions'],
                    'is_featured' => $treatment['is_featured'],
                    'is_active' => true,
                ],
            );
        }
    }
}
