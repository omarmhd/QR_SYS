   <script>
       $(document).ready(function() {
           const queryString = window.location.search;
           const params = new URLSearchParams(queryString);
           const serviceId = params.get('service_id');

           $('#data-table').DataTable({
               processing: true,
               serverSide: false,
               ajax: {
                   url: "{{ route('service-requests.index') }}",
                   data: {
                       service_id: serviceId
                   }
               },
               columns: [{
                       data: 'id',
                       name: 'id'
                   },
                   {
                       data: 'full_name',
                       name: "full_name"
                   },
                   {
                       data: 'email',
                       name: "email"
                   },

                   {
                       data: 'phone',
                       name: "phone"
                   },
                   {
                       data: 'booking_date',
                       name: "booking_date"
                   },
                   {
                       data: 'booking_time',
                       name: "booking_time"
                   },
                   {
                       data: 'guest_number',
                       name: "guest_number"
                   },
                   {
                       data: 'cigar_type',
                       name: "cigar_type"
                   },
                   {
                       data: 'notes',
                       name: "notes"
                   },

                   {
                       data: 'actions',
                       name: "actions"
                   },



               ]

           });
       });
   </script>
