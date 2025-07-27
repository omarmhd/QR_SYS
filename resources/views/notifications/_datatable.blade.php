   <script>
       $(document).ready(function() {
           $('#users-table').DataTable({
               processing: true,
               serverSide: false,
               ajax: "{{route('notifications.index')}}",
               columns: [{
                       data: 'id',
                       name: 'id'
                   },
                   {
                       data: 'title',
                       name: "title"
                   },
                   {
                       data: 'body',
                       name: "body"
                   },
                   {
                       data: 'type',
                       name: "type"
                   },
                   {
                       data: 'sent_at',
                       name: "sent_at"
                   },
                   {
                       data: 'action',
                       name: "action"
                   }


               ]

           });
       });
   </script>