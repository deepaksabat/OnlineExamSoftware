 
@if (Session::has('flash_message'))
    <script type="text/javascript">
        swal({
            title: "{{{ Session::get('flash_message.title') }}}",
            text: "{{{ Session::get('flash_message.text') }}}",
            type: "{{{ Session::get('flash_message.type') }}}",
            timer: 1700,
            showConfirmButton: false
        });
    </script>
@endif

@if (Session::has('flash_overlay'))
    <script type="text/javascript">
        swal({
            title: "{{{ Session::get('flash_overlay.title') }}}",
            text: "{{{ Session::get('flash_overlay.text') }}}",
            type: "{{{ Session::get('flash_overlay.type') }}}",
            confirmButtonText: "Ok"
        });
    </script>
@endif