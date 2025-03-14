<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New PS Unit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('ps_units.store') }}" method="POST"  id="pricing-form">
                        @csrf
                        <div class="space-y-6">
                            <!-- Type Input -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                                <input type="text" name="type" id="type" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                @error('type')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stock Input -->
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                                <input type="number" name="stock" id="stock" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                @error('stock')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div>
                                <button type="submit" id="submit-button" class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Add PS Unit
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
