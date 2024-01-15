@if(session('success'))
        <script>
            swal({
                title: "Success",
                icon: 'success',
                text: {!! json_encode(session('success')) !!}
            });
        </script>
  @endif
  @if(session('error'))
        <script>
            swal({
                title: "Oops..",
                icon: 'error',
                text: {!! json_encode(session('error')) !!}
             });
        </script>
  @endif
  @if ($errors->any())
        <script>let error = "";</script>
        @foreach ($errors->all() as $error)
            <script>error+={!!json_encode($error)!!}</script>
        @endforeach
        <script>
            swal({
                title: "Oops..",
                icon: 'error',
                text: error
             });
        </script>
    @endif
    @if(session('success'))
        <script>
            swal({
            title: "Success",
            icon: 'success',
            text: {!! json_encode(session('success')) !!}
    });
        </script>
    @endif

