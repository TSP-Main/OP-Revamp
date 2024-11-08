@php
$user = auth()->user();
@endphp
<script>
    $(document).ready(function() {
        var user = @json($user);

        // Adding  data in through the api...
        $('body').on('submit','.apiform', function(e) {
            e.preventDefault();
            alert();
            var form = $(this);
            var apiname = form.attr('action');
            var apiurl = "{{ end_url('') }}" + apiname;
            var formData = new FormData(this);
            var bearerToken = "{{session('user')}}";

            $.ajax({
                url: apiurl,
                type: 'POST',
                data: formData,
                headers: {
                    'Authorization': 'Bearer ' + bearerToken
                },
                contentType: false,
                processData: false,
                beforeSend: function() {},
                success: function(response) {

                    if (response.status === 'success') {
                        alert('working');
                    } else if (response.status === 'error') {

                    }
                },
                error: function(xhr, status, error) {
                    console.log(status);

                }
            });
        });

    });
</script>