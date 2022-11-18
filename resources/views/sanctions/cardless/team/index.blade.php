<x-layout>
    <x-slot name="title">Managing sanctions</x-slot>
    <div class="flex flex-col items-center pt-6 px-8 flex-grow">
        <div class="flex flex-row justify-between w-full">
            <p class="text-2xl text-zinc-800 font-semibold mb-6 w-full">Sanctions</p>
            <form action="/eventManagement" method="GET">
                <button class="text-xl font-semibold underline text-zinc-800 hover:cursor-pointer">Back</button>
            </form>
        </div>
        <div class="flex flex-col gap-12">
            <div class="rounded-md overflow-x-auto shadow-xl w-[75rem]">
                <table class="table-auto border-collapse w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-300">
                            <td class="p-3 font-light text-zinc-800">ID</td>
                            <td class="p-3 font-light text-zinc-800">MIN</td>
                            @if ($event->result()->result_type_id == '3')
                                <td class="p-3 font-light text-zinc-800">SET</td>
                            @endif
                            <td class="p-3 font-light text-zinc-800">PLAYER</td>
                            <td class="p-3 font-light text-zinc-800">TEAM</td>
                            <td class="p-3 font-light text-zinc-800">SANCTION</td>
                            <td class="p-3 font-light text-zinc-800">CREATED AT</td>
                            <td class="p-3 font-light text-zinc-800">UPDATED AT</td>
                            <td class="p-3 font-light text-zinc-800 text-center">ACTIONS</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event->opponents() as $team)
                            @foreach ($team->events as $player)
                                @foreach ($player->cardlessSanctions->sortBy(['minute', 'desc']) as $sanction)
                            <tr class="border-b border-slate-300">
                                <td class="p-3 text-zinc-800">{{ $sanction->id }}</td>
                                <td class="p-3 text-zinc-800">{{ $sanction->minute }}'</td> 
                                @if ($event->result()->result_type_id == '3')
                                    <td class="p-3 text-zinc-800">Set {{ $sanction->inSet->set->number }}</td>
                                @endif
                                <td class="p-3 text-zinc-800">
                                    <div class="flex flex-row gap-4 items-center">
                                        <div style="background-image: url({{ asset('images/' . $sanction->eventPlayerTeam->playerTeam->player->picture) }})"
                                            class="h-16 w-16 rounded-full shadow-md bg-center bg-contain 
                                            whitespace-nowrap overflow-hidden bg-no-repeat bg-origin-border 
                                            bg-clip-padding">
                                        </div>
                                        <p>
                                            {{ $sanction->eventPlayerTeam->playerTeam->player->name }}
                                            {{ $sanction->eventPlayerTeam->playerTeam->player->surname }}
                                        </p>
                                    </div>
                                </td>
                                <td class="p-3 text-zinc-800">
                                    {{ $sanction->eventPlayerTeam->playerTeam->team->name}}
                                </td>
                                <td class="p-3 text-zinc-800">
                                    {{ $sanction->sanction->description}}
                                </td>
                                <td class="p-3 text-zinc-800">
                                    {{ $sanction->created_at }}
                                </td>
                                <td class="p-3 text-zinc-800">
                                    {{ $sanction->updated_at }}
                                </td>
                                <td class="p-3 text-zinc-800">
                                    <div class="flex flex-col items-center">
                                        <form action="/sanctions/cardless/team/edit/{{ $sanction->id }}" method="GET">
                                            <button type="submit" class="font-semibold text-blue-600">Edit</button>
                                        </form>
                                        <form action="/sanctions/cardless/team/delete/{{ $sanction->id  }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="font-semibold text-blue-600">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if (session('statusDelete') && session('deletedId'))
            <x-status-delete-get>
                <x-slot name="action">/sanctions/cardless/team/restore/{{ session('deletedId') }}</x-slot>
            </x-status-delete-get>
        @endif

        @if (session('statusRestore'))
            <x-status-restore />
        @endif
    </div>
    <x-create-section>
        <x-slot name="action">sanctions/cardless/team/create/{{ $event->id }}</x-slot>
        @livewire('select-team-player', ['eventId' => $event->id])

        <div class="flex flex-col gap-1">
            <label for="player" class="font-medium text-zinc-700">
                Minute
            </label>
            <input class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner"
                placeholder="Enter minute" value="{{ old('minute') }}"
                type="number" min="0" name="minute" />
            <p class="text-sm text-red-600">
                {{ $errors->first('minute') }}
            </p>
        </div>

        <div class="flex flex-col gap-1">
            <label for="sanction" class="font-medium text-zinc-700">Sanction</label>
            <select name="sanction" class="w-64 bg-slate-200 px-3 py-1 rounded-md shadow-inner" autocomplete="off">
                <option value="">-- Select sanction --</option>
                @foreach($sanctions as $sanction)
                    <option value="{{ $sanction->id }}" 
                        @if (old('sanction') == $sanction->id) selected @endif
                    >{{ $sanction->description }}</option>
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('sanction') }}</p>
        </div>
        @if ($event->result()->result_type_id == '3')
            <div class="flex flex-col gap-1">
                <label class="font-medium text-zinc-700" for="set">Set</label>
                <select class="w-64 bg-slate-200 px-3 py-1 rounded-md shadow-inner" name="set" autocomplete="off">
                    <option value="">-- select set --</option>
                    @foreach ($event->result()->sets as $set)
                        <option value="{{ $set->id }}"
                            @if (old('set') == $set->id) selected @endif>
                            {{ $set->number }}
                        </option>
                    @endforeach
                </select>
                <p class="text-sm text-red-600">{{ $errors->first('set') }}</p>
            </div>
        @endif
    </x-create-section>
</x-layout>
