<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for booking input (Tailwind CSS) -->
    <div id="bookingModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <div class="flex justify-between items-center border-b pb-3">
                <h5 class="text-xl font-semibold">Add Booking</h5>
                <button id="closeModalButton" class="text-gray-500 hover:text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="bookingForm">
                <div class="mb-4">
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
                    <div id="ps_unit_id_error" class="text-red-500 text-xs mt-1"></div>
                </div>
                <div class="mb-4">
                    <label for="customer_name" class="block text-sm font-medium text-gray-700">Customer Name</label>
                    <input type="text" id="customer_name" name="customer_name" class="mt-2 p-2 w-full border border-gray-300 rounded-md" required>
                    <div id="customer_name_error" class="text-red-500 text-xs mt-1"></div>
                </div>
                <div class="mb-4">
                    <label for="customer_contact" class="block text-sm font-medium text-gray-700">Customer Contact</label>
                    <input type="text" id="customer_contact" name="customer_contact" class="mt-2 p-2 w-full border border-gray-300 rounded-md" required>
                    <div id="customer_contact_error" class="text-red-500 text-xs mt-1"></div>
                </div>
                <div class="mb-4">
                    <label for="customer_email" class="block text-sm font-medium text-gray-700">Customer Email</label>
                    <input type="email" id="customer_email" name="customer_email" class="mt-2 p-2 w-full border border-gray-300 rounded-md" required>
                    <div id="customer_email_error" class="text-red-500 text-xs mt-1"></div>
                </div>

                <div class="mb-4">
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="text" id="start_date" name="start_date" class="mt-2 p-2 w-full border border-gray-300 rounded-md" readonly>
                </div>
                <div class="mb-4">
                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                    <input type="text" id="end_date" name="end_date" class="mt-2 p-2 w-full border border-gray-300 rounded-md" readonly>
                </div>
            </form>
            <div class="flex justify-end space-x-2">
                <button type="button" id="saveBookingButton" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Save Booking</button>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var SITEURL = "{{ url('/admin') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var calendar = $('#calendar').fullCalendar({
                editable: true,
                events: SITEURL + "/rentals",
                displayEventTime: false,
                eventRender: function(event, element, view) {
                    if (event.allDay === 'true') {
                        event.allDay = true;
                    } else {
                        event.allDay = false;
                    }
                },
                selectable: true,
                selectHelper: true,
                select: function(start, end, allDay) {
                    $('#start_date').val($.fullCalendar.formatDate(start, "Y-MM-DD"));
                    $('#end_date').val($.fullCalendar.formatDate(end, "Y-MM-DD"));
                    $('#bookingModal').removeClass('hidden'); // Show the modal using jQuery
                    $('#saveBookingButton').data('start', start);
                    $('#saveBookingButton').data('end', end);
                },
                eventClick: function(data) {
                    // Mengarahkan ke halaman detail booking saat event diklik
                    window.location.href = `${SITEURL}/rentals/${data.id}`; // Mengarahkan ke halaman detail booking
                }
            });

            // Save booking from modal form
            $('#saveBookingButton').on('click', function(e) {
                e.preventDefault();
                var customer_name = $('#customer_name').val();
                var customer_email = $('#customer_email').val();
                var ps_unit_id = $('#ps_unit_id').val();
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();

                // Reset errors
                $('#customer_name_error').text('');
                $('#customer_contact_error').text('');
                $('#customer_email_error').text('');
                $('#ps_unit_id_error').text('');

                if (customer_name && ps_unit_id) {
                    var formData = new FormData($('#bookingForm')[0]);
                    formData.append('customer_email', customer_email);
                    formData.append('start_date', start_date);
                    formData.append('end_date', end_date);
                    formData.append('ps_unit_id', ps_unit_id);
                    formData.append('type', 'add'); // Add booking type

                    $.ajax({
                        url: SITEURL + "/rentals",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            displayMessage("Booking Created Successfully");
                            // Check if snap_token is available and redirect to Midtrans
                            var snapToken = data.snap_token;
                            var id        = data.id;
                            console.log(snapToken);
                            if (snapToken && typeof snapToken === 'string') {

                                window.location.href = `${SITEURL}/rentals/${id}`;
                            } else {
                                console.error('Invalid snap_token');
                            }
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON.errors;
                            if (errors) {
                                if (errors.customer_name) {
                                    $('#customer_name_error').text(errors.customer_name[0]);
                                }
                                if (errors.customer_contact) {
                                    $('#customer_contact_error').text(errors.customer_contact[0]);
                                }
                                if (errors.ps_unit_id) {
                                    $('#ps_unit_id_error').text(errors.ps_unit_id[0]);
                                }
                            }
                        }
                    });
                } else {
                    if (!customer_name) {
                        $('#customer_name_error').text('Customer name is required');
                    }
                    if (!customer_email) {
                        $('#customer_email_error').text('Customer email is required');
                    }
                    if (!ps_unit_id) {
                        $('#ps_unit_id_error').text('PS Unit is required');
                    }
                    $('#customer_contact_error').text('Customer contact is required');
                }
            });

            // Close the modal
            $('#closeModalButton').on('click', function() {
                $('#bookingModal').addClass('hidden');
            });
        });

        function displayMessage(message) {
            toastr.success(message, 'Booking');
        }


    </script>

</x-app-layout>
