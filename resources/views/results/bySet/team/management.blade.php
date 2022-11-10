<x-layout>
    <x-slot name="title">Updating score</x-slot>
    <div class="flex flex-col items-center pt-6 px-8 flex-grow">
        <div class="flex flex-row justify-between w-full">
            <p class="text-2xl text-zinc-800 font-semibold mb-6 w-full">Points</p>
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
                            <td class="p-3 font-light text-zinc-800">SET</td>
                            <td class="p-3 font-light text-zinc-800">MIN</td>
                            <td class="p-3 font-light text-zinc-800">POINTS</td>
                            <td class="p-3 font-light text-zinc-800">PLAYER</td>
                            <td class="p-3 font-light text-zinc-800">TEAM</td>
                            <td class="p-3 font-light text-zinc-800">CREATED AT</td>
                            <td class="p-3 font-light text-zinc-800">UPDATED AT</td>
                            <td class="p-3 font-light text-zinc-800 text-center">ACTIONS</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event->result()->teamPoints()->get()->sortBy([['set.number', 'asc'], ['minute', 'desc']]) as $point)
                            <tr class="border-b border-slate-300">
                                <td class="p-3 text-zinc-800">{{ $point->id }}</td>
                                <td class="p-3 text-zinc-800">Set {{ $point->set->number }}</td>
                                <td class="p-3 text-zinc-800">{{ $point->minute }}'</td>
                                <td @class([
                                    'p-3',
                                    'font-semibold',
                                    'text-green-600' => $point->points_in_favor !== 0,
                                    'text-red-600' => $point->points_against !== 0,
                                ])>
                                    {{ $point->points_in_favor == 0 ? $point->points_against . ' against' : $point->points_in_favor . ' in favor' }}
                                </td>
                                <td class="p-3 text-zinc-800">
                                    <div class="flex flex-row gap-4 items-center">
                                        <div style="background-image: url({{ asset('images/' . $point->eventPlayerTeam->playerTeam->player->picture) }})"
                                            class="h-16 w-16 rounded-full shadow-md bg-center bg-contain 
                                            whitespace-nowrap overflow-hidden bg-no-repeat bg-origin-border 
                                            bg-clip-padding">
                                        </div>
                                        <p>
                                            {{ $point->eventPlayerTeam->playerTeam->player->name ?? '' }}
                                            {{ $point->eventPlayerTeam->playerTeam->player->surname }}
                                        </p>
                                    </div>
                                </td>
                                <td class="p-3 text-zinc-800">
                                    {{ $point->eventPlayerTeam->playerTeam->team->name ?? '' }}
                                </td>
                                <td class="p-3 text-zinc-800">
                                    {{ $point->created_at }}
                                </td>
                                <td class="p-3 text-zinc-800">
                                    {{ $point->updated_at }}
                                </td>
                                <td class="p-3 text-zinc-800">
                                    <div class="flex flex-col items-center">
                                        <form action="/set/team/edit/{{ $point->id }}" method="GET">
                                            <button class="font-semibold text-blue-600">Edit</button>
                                        </form>
                                        <form action="/set/team/delete/{{ $point->id }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="font-semibold text-blue-600">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if (session('statusDelete') && session('deletedId'))
            <x-status-delete-get>
                <x-slot name="action">/set/team/restore/{{ session('deletedId') }}</x-slot>
            </x-status-delete-get>
        @endif

        @if (session('statusRestore'))
            <x-status-restore />
        @endif
    </div>
    @livewire('result.by-set.create-team-set-point', ['result' => $event->result()])
</x-layout>
