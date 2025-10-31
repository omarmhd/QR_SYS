   <script>
       $(document).ready(function() {
           $('#data-table').DataTable({
               processing: true,
               serverSide: false,
               order: [],
               ajax: "{{route('payments.index')}}",
               columns: [
                   { data: 'id', name: 'id' },
                   { data: 'order_id', name: 'order_id' },
                   { data: 'id_number', name: 'id_number' },
                   { data: 'cui', name: 'cui' },

                   { data: 'user', name: 'user' },
                   { data: 'phone', name: 'phone' },

                   { data: 'plan', name: 'plan' },
                   { data: 'amount', name: 'amount' },
                   { data: 'payment_method', name: 'payment_method' },
                   { data: 'status', name: 'status', orderable: false, searchable: false },
                   { data: 'paid_at', name: 'paid_at' },
                   { data: 'actions', name: 'actions', orderable: false, searchable: false },
               ]

           });
       });
   </script>
