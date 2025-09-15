<script>
    $(document).ready(function() {

        $('#data-table').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('contact-messages.index') }}"
            },
            columns: [{
                data: 'id',
                name: 'id'
            },

                {
                    data: 'user_name',
                    name: "user_name"
                },

                {
                    data: 'user_email',
                    name: "user_email"
                },
                {
                    data: 'title',
                    name: "title"
                },
                {
                    data: 'message',
                    name: "message"
                },
                {
                    data: 'created_at',
                    name: "created_at"
                },
                {
                    data: 'action',
                    name: "action"
                },



            ]

        });
    });
</script>
