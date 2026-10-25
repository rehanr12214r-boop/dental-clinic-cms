<x-layouts.admin
    title="Create Dentist"
    heading="New dentist profile"
    headingSub="Add a member of the clinic care team"
>
    @include('admin.dentists._form', [
        'dentist' => $dentist,
        'action' => route('admin.dentists.store'),
        'method' => 'POST',
    ])
</x-layouts.admin>
