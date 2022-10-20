<x-layout>
    <x-slot name="title">Team update</x-slot>
    <div class="shadow-xl bg-white">
        <form method="get" action="/teamManagement" class="bg-slate-200 w-full flex flex-row justify-end gap-6 items-center py-4 px-14">
            <button type="submit" class="text-zinc-800" id="cancel">Back</button>
        </form>
        <div class="flex flex-row">
            <div class="flex flex-col items-center py-5 px-8 gap-5 border-r-2 border-slate-600">
                <p class="font-semibold text-zinc-800 w-full">Team roster</p>
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
                                        <td class="p-3 text-zinc-800 text-right">{{ $playerInTeam->shirt_number }}</td>
                                        <td class="p-3 text-zinc-800">{{ $playerInTeam->contract_start }}</td>
                                        <td class="p-3 text-center">
                                            <form action="/playerTeamDelete" method="post">
                                                @csrf
                                                <input type="hidden" name="playerTeamId" value="{{ $playerInTeam->id }}">
                                                <button class="text-blue-600 font-semibold" type="submit">Delete</button>
                                            </form>
                                            <form action="/playerTeamUpdate/{{ $playerInTeam->id }}" method="get">
                                                <button type="submit" class="text-blue-600 font-semibold">Edit</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                @if(session('statusDelete') && session('deletedId'))
                    <x-status-delete>
                        <x-slot name="action">/playerTeamRestore</x-slot>
                        <x-slot name="id">{{ session('deletedId') }}</x-slot>
                    </x-status-delete>
                @endif
                @if (session('statusRegister'))
                    <p class="p-4 text-green-600 bg-green-100 rounded-md">{{ session('statusRegister') }}</p>
                @endif
            </div>
            <div class="flex flex-col items-start py-5 px-8 gap-5">
                <p class="font-semibold text-zinc-800 text-xl">Add player to team roster</p>
                <div class="flex flex-row gap-6">
                    <div class="">
                        <form action="/playerTeamRegister" method="POST" class="flex flex-col gap-2">
                            @csrf
                            <input type="hidden" name="teamId" value="{{ $team->id }}">
                            <div class="flex flex-col gap-1">
                                <label for="position" class="font-medium text-zinc-700">Position</label>
                                <select name="positionId" id="position" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                                    <option selected disabled>Choose position</option>
                                    @foreach ($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                    @endforeach
                                </select>
                                <p class="text-sm text-red-600">{{ $errors->first('positionId') }}</p>
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
                            <livewire:player-table-search/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form method="GET" action="teamManagement" id="redirect">
        @csrf
    </form>
    <script>
        const cancel = document.getElementById('cancel');
        cancel.addEventListener('click', () => {
            document.getElementById('redirect').submit();
        });
    </script>
</x-layout>