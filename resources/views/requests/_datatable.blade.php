   <script>
       $(document).ready(function() {
           $('#users-table').DataTable({
               processing: true,
               serverSide: false,
               ajax: "{{route('requests.index')}}",
               columns: [{
                       data: 'id',
                       name: 'id'
                   },
                   {
                       data: 'name',
                       name: "name"
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
                       data: 'dob',
                       name: "dob"
                   },
                   {
                       data: 'plan_name',
                       name: "plan_name"
                   },
                   {
                       data: 'approval_status',
                       name: "approval_status"
                   },

                   {
                       data: 'actions',
                       name: "actions"
                   },



               ]

           });
       });
   </script>