<form action="/{{ $action }}" method="post" {{ $attributes->merge(['class' => 'flex flex-col items-start gap-5 p-0 pt-6 rounded-md bg-white shadow-md w-fit m-auto mt-5 mb-5']) }}>
    <p class="text-2xl font-semibold text-zinc-800 px-6 w-full">Edit</p>
    @csrf
    <div class="flex flex-col items-start px-6 gap-2 flex-wrap">
        {{ $slot }}
    </div>
    <div class="flex flex-row justify-end items-center py-3 px-6 bg-slate-200 w-full gap-10">
        <a class="text-zinc-800 hover:cursor-pointer" id="cancel">Cancel</a>
        <button class="bg-blue-600 text-white px-3 py-1 w-fit rounded-md" type="submit">Save</button>
    </div>
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