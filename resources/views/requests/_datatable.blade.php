   <script>
       $(document).ready(function() {
           var table=$('#users-table').DataTable({
               processing: true,
               serverSide: true,
               order: [],
               ajax: "{{route('requests.index')}}",
               columns: [
                   // {
                   // // data:"checkbox",
                   // // name:"checkbox"
                   // }
                   {
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

           $('#check-all').on('click', function () {


               var rows = table.rows({ 'page': 'current' }).nodes();
               $('input[type="checkbox"].row-check', rows).prop('checked', this.checked);
           });
           $('#users-table tbody').on('change', 'input.row-check', function () {
               if (!this.checked) {
                   var el = $('#checkAll').get(0);
                   if (el && el.checked) {
                       el.checked = false;
                   }
               }
           });

       });


   </script>
