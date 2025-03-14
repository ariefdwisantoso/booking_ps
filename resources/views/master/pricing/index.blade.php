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
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $price->base_rate }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $price->weekend_surcharge }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            <a href="{{ route('pricing.edit', $price->id) }}" class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                                            <form action="{{ route('pricing.destroy', $price->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
