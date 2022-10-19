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
                <div class="w-full overflow-x-auto rounded-md border border-slate-300">
                    <table class="table-auto border-collapse whitespace-nowrap w-full">
                        <thead>
                            <tr class="bg-slate-300">
                                <td class="p-3 font-light text-zinc-800">Name</td>
                                <td class="p-3 font-light text-zinc-800">Country</td>
                                <td class="p-3 font-light text-zinc-800">Position</td>
                                <td class="p-3 font-light text-zinc-800">Shirt number</td>
                                <td class="p-3 font-light text-zinc-800">Contract start</td>
                                <td class="p-3 font-light text-zinc-800">Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($team))
                                @foreach ($team->playerTeams as $playerInTeam)
                                    <tr class="border-b border-slate-300">
                                        <td class="p-3 text-zinc-800">
                                            {{ $playerInTeam->player->name }} {{ $playerInTeam->player->surname }}
                                        </td>
                                        <td class="p-3 text-zinc-800">{{ $playerInTeam->player->country->name }}</td>
                                        <td class="p-3 text-zinc-800">{{ $playerInTeam->position->name }}</td>
                                        <td class="p-3 text-zinc-800">{{ $playerInTeam->shirt_number }}</td>
                                        <td class="p-3 text-zinc-800">{{ $playerInTeam->contract_start }}</td>
                                        <td class="p-3">
                                            <button class="text-blue-600 font-semibold">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="flex flex-col items-start py-5 px-8 gap-5">
                <form action="">
                    <div class="flex flex-col gap-1">
                        <label for="position" class="font-medium text-zinc-700">Position</label>
                        <select name="position" id="position" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                            <option selected disabled>Choose position</option>
                            @foreach ($positions as $position)
                                <option value="{{ $position->id }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-sm text-red-600">{{ $errors->first('position') }}</p>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="shirtNumber" class="font-medium text-zinc-700">Shirt number</label>
                        <input type="number" name="shirtNumber" id="shirtNumber" placeholder="Enter shirtNumber" value="{{ old('shirtNumber') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                        <p class="text-sm text-red-600">{{ $errors->first('shirtNumber') }}</p>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="contractStart" class="font-medium text-zinc-700">Contract start</label>
                        <input type="date" name="contractStart" id="contractStart" placeholder="Enter contractStart" value="{{ old('contractStart') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                        <p class="text-sm text-red-600">{{ $errors->first('contractStart') }}</p>
                    </div>
                    <livewire:player-table-search />
                </form>
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