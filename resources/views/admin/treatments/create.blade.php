<x-layouts.admin
    title="New treatment"
    heading="New treatment"
    headingSub="Add a service to the clinic's bookable treatments"
>

    @include('admin.treatments._form', ['treatment' => $treatment])

</x-layouts.admin>
