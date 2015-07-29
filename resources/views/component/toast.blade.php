@if(Session::has('toast') || isset($toast))
    <script type="text/javascript">
        $(document).ready(function () {
            $("body").toast({content: "{{ Session::has('toast')? Session::pull('toast') : $toast }}"})
        });
    </script>
@endif
<div class="toast"></div>