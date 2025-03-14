<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Show Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Detail Booking -->
                    <h3 class="text-xl font-semibold">Booking Details</h3>
                    <table class="min-w-full mt-4">
                        <tr>
                            <td class="py-2 px-4 font-medium">Customer Name</td>
                            <td class="py-2 px-4">{{ $rentals->customer_name }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 font-medium">Customer Contact</td>
                            <td class="py-2 px-4">{{ $rentals->customer_contact }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 font-medium">Customer Email</td>
                            <td class="py-2 px-4">{{ $rentals->customer_email }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 font-medium">Booking Date</td>
                            <td class="py-2 px-4">
                                {{ \Carbon\Carbon::parse($rentals->start_date)->translatedFormat('l, j F Y') }} 
                                to 
                                {{ \Carbon\Carbon::parse($rentals->end_date)->translatedFormat('l, j F Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 font-medium">Cost</td>
                            <td class="py-2 px-4">Rp {{ number_format($rentals->cost, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 font-medium">Weekend Surcharge</td>
                            <td class="py-2 px-4">Rp {{ number_format($rentals->weekend_surcharge, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 font-medium">Total Amount</td>
                            <td class="py-2 px-4">Rp {{ number_format($rentals->amount, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                    <div class="mt-6">
                        @if ($rentals->status == 'pending')
                            <button id="pay-button" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Proceed to Payment
                            </button>
                        @elseif ($rentals->status == 'paid')
                            Payment Successfully
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Midtrans Snap.js -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

    <script>
        const payButton = document.querySelector('#pay-button');

        if (payButton) {
            payButton.addEventListener('click', function(e) {
                e.preventDefault();

                // snap_token
                const snapToken = '{{ $rentals->snap_token }}';

                if (snapToken) {
                    snap.pay(snapToken, {
                        onSuccess: function(result) {
                            console.log("Payment Success:", result);
                        },
                        onPending: function(result) {
                            console.log("Payment Pending:", result);
                        },
                        onError: function(result) {
                            console.log("Payment Error:", result);
                        }
                    });
                } else {
                    console.error("Snap token is missing or invalid");
                }
            });
        }
    </script>
</x-app-layout>
