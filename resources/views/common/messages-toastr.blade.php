@if (session()->has('process_result'))
    <script>
        $(document).ready(function () {
            toastr.{{ session('process_result')['status'] }}('{{ session('process_result')['content'] }}');
        });
    </script>
@endif