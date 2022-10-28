<div class="flex flex-col items-start gap-4 ">
    <div class="flex flex-row justify-between w-full">
        <div>
            <label for="search" class="font-medium text-zinc-700 mr-">Search player:</label>
            <input wire:model="search" type="text" name="search" id="search" placeholder="Search by name" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('playerId') }}</p>
        </div>
        <button class="bg-blue-600 text-white px-3 py-1 w-fit rounded-md" type="submit">Save</button>
    </div>
    <div class="overflow-x-auto w-[35rem] rounded-md border border-slate-300">
        <table class="table-auto border-collapse whitespace-nowrap w-full">
            <thead>
                <tr class="bg-slate-300">
                    <td class="p-3 font-light text-zinc-800">NAME</td>
                    <td class="p-3 font-light text-zinc-800">COUNTRY</td>
                    <td class="p-3 font-light text-zinc-800 w-1/5">ACTIONS</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($players as $player)
                    <tr class="border-b border-slate-300">
                        <td class="p-3 text-zinc-800">
                            <div class="flex flex-row items-center gap-4">
                                <img src="{{ asset('images/' . $player->picture) }}" class="h-12 w-12 rounded-full shadow-sm">
                                <p>
                                    {{ $player->name }} {{ $player->surname }}
                                </p>
                            </div>
                        </td>
                        <td class="p-3 text-zinc-800">{{ $player->country->name }}</td>
                        <td class="p-3 text-zinc-800 text-center w-1/5">
                            <input type="radio" name="playerId" id="playerId" value="{{ $player->id }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
