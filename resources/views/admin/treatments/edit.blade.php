<x-layouts.admin
    title="Edit treatment"
    heading="Edit treatment"
    :headingSub="'Update the details of '.$treatment->name"
>

    @include('admin.treatments._form', ['treatment' => $treatment])

</x-layouts.admin>
