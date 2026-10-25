<x-layouts.admin
    title="Edit Dentist"
    heading="Edit dentist profile"
    headingSub="Update {{ $dentist->name }}"
>
    @include('admin.dentists._form', [
        'dentist' => $dentist,
        'action' => route('admin.dentists.update', $dentist),
        'method' => 'PUT',
    ])
</x-layouts.admin>
