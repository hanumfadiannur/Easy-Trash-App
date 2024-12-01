@if (Session::has('success'))
    <script>
        Swal.fire({
            title: "Success!",
            text: "{{ Session::get('success') }}",
            icon: "success"
        });
    </script>
@endif

@if (Session::has('error'))
    <script>
        Swal.fire({
            title: "Error!",
            text: "{{ Session::get('error') }}",
            icon: "error"
        });
    </script>
@endif
