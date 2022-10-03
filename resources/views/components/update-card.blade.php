<form action="/{{ $action }}" method="post" class="flex flex-col items-start gap-5 p-0 pt-6 rounded-md bg-white overflow-hidden shadow-md w-fit m-auto mt-5">
    <p class="text-2xl font-semibold text-zinc-800 px-6 w-full">Edit</p>
    @csrf
    {{ $slot }}
</form>
<form method="GET" action="/{{ $backTo }}" id="redirect">
    @csrf
</form>
@if(session('isRedirected') == 'true')
    <script>
        setTimeout(() => {
            document.getElementById('redirect').submit();
        }, 4000);
    </script>
@endif
<script>
    const cancel = document.getElementById('cancel');
    cancel.addEventListener('click', () => {
        document.getElementById('redirect').submit();
    });
</script>