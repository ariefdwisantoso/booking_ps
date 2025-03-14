<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pricing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('pricing.create') }}" class="btn btn-primary mb-4 inline-block px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">
                        Add New Pricing
                    </a>

                    <div class="overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-100 border-b">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Unit Type</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Base Rate</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Weekend Surcharge</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pricing as $price)
                                    <tr class="border-b">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $price->psUnit->type }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">Rp. {{ number_format($price->base_rate, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">Rp. {{ number_format($price->weekend_surcharge, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('pricing.edit', $price->id) }}" 
                                                class="px-3 py-1 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-700 transition duration-300">
                                                    Edit
                                                </a>
                                                <form id="delete-form-{{ $price->id }}" action="{{ route('pricing.destroy', $price->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete({{ $price->id }})"
                                                            class="px-3 py-1 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-700 transition duration-300">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $pricing->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Delete!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>
