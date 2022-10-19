<div>
    {{-- Be like water. --}}
    <input type="text" name="search" placeholder="Search by name" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
    <div class="overflow-x-auto w-full rounded-md border border-slate-300">
        <table class="table-auto border-collapse whitespace-nowrap w-full">
            <thead>
                <tr class="bg-slate-300">
                    <td class="p-3 font-light text-zinc-800">NAME</td>
                    <td class="p-3 font-light text-zinc-800">COUNTRY</td>
                    <td class="p-3 font-light text-zinc-800">ACTIONS</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($players as $player)
                    <tr class="border-b border-slate-300">
                        <td class="p-3 text-zinc-800">{{ $player->name }} {{ $player->surname }}</td>
                        <td class="p-3 text-zinc-800">{{ $player->country->name }}</td>
                        <td class="p-3 text-zinc-800">
                            <input type="radio" name="playerId" id="playerId" value="{{ $player->id }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
