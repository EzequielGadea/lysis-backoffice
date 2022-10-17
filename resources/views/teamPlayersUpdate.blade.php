<x-layout>
    <x-slot name="title">Team update</x-slot>
    <div class="shadow-xl bg-white">
        <div class="bg-slate-200 w-full flex flex-row justify-end items-center py-4 px-14">
            <a class="text-zinc-800 hover:cursor-pointer" id="cancel">Cancel</a>
            <button class="bg-blue-600 text-white px-3 py-1 w-fit rounded-md" type="submit">Save</button>
        </div>
        <div class="flex flex-row">
            <div class="flex flex-col items-start py-5 px-8 gap-5 border-r-2 border-slate-600">
                <p class="font-semibold text-zinc-800">Jugadores</p>
                <div class="w-full overflow-x-auto rounded-md">
                    <table class="table-auto border-collapse whitespace-nowrap w-full">
                        <thead>
                            <tr class="bg-slate-300">
                                <td class="p-3 font-light text-zinc-800">Name</td>
                                <td class="p-3 font-light text-zinc-800">Country</td>
                                <td class="p-3 font-light text-zinc-800">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($team))
                                @foreach ($team->players as $player)
                                    <tr class="border-b border-slate-300">
                                        <td class="p-3 text-zinc-800">
                                            {{ $player->name }} {{ $player->surname }}
                                        </td>
                                        <td class="p-3 text-zinc-800">
                                            {{ $player->country->name }}
                                        </td>
                                        <td class="p-3">
                                            <button class="text-blue-600 font-semibold">Add</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <form method="GET" action="teamManagement" id="redirect">
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
</x-layout>