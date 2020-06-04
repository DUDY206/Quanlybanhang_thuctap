@if(!isset(Auth::user()->sdt))
  <script type="text/javascript">
    window.location = "/login";
  </script>
@endif
