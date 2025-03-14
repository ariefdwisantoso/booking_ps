<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Pricing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('pricing.store') }}" method="POST" id="pricing-form">
                        @csrf
                        <div class="space-y-6">
                            <!-- PS Unit Dropdown -->
                            <div>
                                <label for="ps_unit_id" class="block text-sm font-medium text-gray-700">Type</label>
                                <select name="ps_unit_id" id="ps_unit_id" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                    <option value="">Select PS Unit</option>
                                    @foreach ($psUnits as $psUnit)
                                        {{-- If the ps_unit_id is already selected, we do not display it again --}}
                                        @if(old('ps_unit_id') != $psUnit->id)
                                            <option value="{{ $psUnit->id }}">{{ $psUnit->type }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('ps_unit_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Base Rate Input -->
                            <div>
                                <label for="base_rate" class="block text-sm font-medium text-gray-700">Base Rate</label>
                                <input type="number" name="base_rate" id="base_rate" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                @error('base_rate')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Weekend Rate Input -->
                            <div>
                                <label for="weekend_surcharge" class="block text-sm font-medium text-gray-700">Weekend Surcharge</label>
                                <input type="number" name="weekend_surcharge" id="weekend_surcharge" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                @error('weekend_surcharge')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div>
                                <button type="submit" id="submit-button" class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Add Pricing
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('pricing-form').addEventListener('submit', function(e) {
            // Menonaktifkan tombol submit setelah klik pertama
            document.getElementById('submit-button').disabled = true;
        });
    </script>
</x-app-layout>
