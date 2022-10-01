<div class="bg-slate-50 flex flex-col gap-6 w-80 px-8 py-6">
    <p class="text-zinc-800 text-2xl font-semibold">Create</p>
     <form action="/{{ $action }}" method="post" class="flex flex-col gap-3">
        @csrf
        {{ $slot }}
        <button type="submit" class="bg-blue-600 text-white px-3 py-1 w-fit rounded-md">Submit</button>
     </form>
    @if (session('statusCreate'))
        <p class="p-4 text-green-600 bg-green-100 rounded-md"> {{ session('statusCreate') }}</p>
    @endif
</div>