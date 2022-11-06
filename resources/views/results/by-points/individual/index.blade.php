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
                            <td class="p-3 font-light text-zinc-800">MIN</td>
                            <td class="p-3 font-light text-zinc-800">POINTS</td>
                            <td class="p-3 font-light text-zinc-800">PLAYER</td>
                            <td class="p-3 font-light text-zinc-800">CREATED AT</td>
                            <td class="p-3 font-light text-zinc-800">UPDATED AT</td>
                            <td class="p-3 font-light text-zinc-800 text-center">ACTIONS</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event->result()->playerLocalPoints->sortBy([['minute', 'desc']]) as $point)
                            <tr class="border-b border-slate-300">
                                <td class="p-3 text-zinc-800">{{ $point->id }}</td>
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
                                        <div style="background-image: url({{ asset('images/' . $point->playerLocal->player->picture) }})"
                                            class="h-16 w-16 rounded-full shadow-md bg-center bg-contain 
                                            whitespace-nowrap overflow-hidden bg-no-repeat bg-origin-border 
                                            bg-clip-padding">
                                        </div>
                                        <p>
                                            {{ $point->playerLocal->player->name ?? '' }}
                                            {{ $point->playerLocal->player->surname }}
                                        </p>
                                    </div>
                                </td>
                                <td class="p-3 text-zinc-800">
                                    {{ $point->created_at }}
                                </td>
                                <td class="p-3 text-zinc-800">
                                    {{ $point->updated_at }}
                                </td>
                                <td class="p-3 text-zinc-800">
                                    <div class="flex flex-col items-center">
                                        <form action="/points/individual/local/edit/{{ $point->id }}" method="GET">
                                            <button class="font-semibold text-blue-600">Edit</button>
                                        </form>
                                        <form action="/points/individual/local/delete/{{ $point->id }}"
                                            method="POST">
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
            <div class="rounded-md overflow-x-auto shadow-xl w-[75rem]">
                <table class="table-auto border-collapse w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-300">
                            <td class="p-3 font-light text-zinc-800">ID</td>
                            <td class="p-3 font-light text-zinc-800">MIN</td>
                            <td class="p-3 font-light text-zinc-800">POINTS</td>
                            <td class="p-3 font-light text-zinc-800">PLAYER</td>
                            <td class="p-3 font-light text-zinc-800">CREATED AT</td>
                            <td class="p-3 font-light text-zinc-800">UPDATED AT</td>
                            <td class="p-3 font-light text-zinc-800 text-center">ACTIONS</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event->result()->playerVisitorPoints->sortBy([['minute', 'desc']]) as $point)
                            <tr class="border-b border-slate-300">
                                <td class="p-3 text-zinc-800">{{ $point->id }}</td>
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
                                        <div style="background-image: url({{ asset('images/' . $point->playerVisitor->player->picture) }})"
                                            class="h-16 w-16 rounded-full shadow-md bg-center bg-contain 
                                            whitespace-nowrap overflow-hidden bg-no-repeat bg-origin-border 
                                            bg-clip-padding">
                                        </div>
                                        <p>
                                            {{ $point->playerVisitor->player->name ?? '' }}
                                            {{ $point->playerVisitor->player->surname }}
                                        </p>
                                    </div>
                                </td>
                                <td class="p-3 text-zinc-800">
                                    {{ $point->created_at }}
                                </td>
                                <td class="p-3 text-zinc-800">
                                    {{ $point->updated_at }}
                                </td>
                                <td class="p-3 text-zinc-800">
                                    <div class="flex flex-col items-center">
                                        <form action="/points/individual/visitor/edit/{{ $point->id }}"
                                            method="GET">
                                            <button class="font-semibold text-blue-600">Edit</button>
                                        </form>
                                        <form action="/points/individual/visitor/delete/{{ $point->id }}"
                                            method="POST">
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
                <x-slot name="action">/points/individual/{{ session('side') }}/restore/{{ session('deletedId') }}
                </x-slot>
            </x-status-delete-get>
        @endif

        @if (session('statusRestore'))
            <x-status-restore />
        @endif
    </div>
    <form action="/points/individual/create/{{ $event->result()->id }}" method="POST"
        class="bg-slate-50 flex flex-col gap-6 w-80 px-8 py-6">
        @csrf

        <div class="flex flex-col gap-1">
            <label for="player" class="font-medium text-zinc-700">
                Player
            </label>
            <select name="player" autocomplete="off" class="w-64 bg-slate-200 px-3 py-1 rounded-md shadow-inner">
                <option value="">-- Choose player --</option>
                @foreach ($event->opponents() as $player)
                    <option value="{{ $player->id }}" @if (old('player') == $player->id) selected @endif>
                        {{ $player->name . ' ' . $player->surname }}
                    </option>
                @endforeach
            </select>
            <p class="text-sm text-red-600">
                {{ $errors->first('player') }}
            </p>
        </div>

        <div class="flex flex-col gap-1">
            <label for="minute" class="font-medium text-zinc-700">
                Minute
            </label>
            <input type="number" min="0" value="{{ old('minute') }}" name="minute" placeholder="Enter minute"
                class="w-64 bg-slate-200 px-3 py-1 rounded-md 
                     placeholder:text-zinc-600 shadow-inner" />
            <p class="text-sm text-red-600">
                {{ $errors->first('minute') }}
            </p>
        </div>

        <div class="flex flex-col gap-1">
            <label for="points" class="font-medium text-zinc-700">
                Points
            </label>
            <input type="number" min="1" value="{{ old('points') }}" name="points" placeholder="Enter amount of points"
                class="w-64 bg-slate-200 px-3 py-1 rounded-md 
                     placeholder:text-zinc-600 shadow-inner" />
            <p class="text-sm text-red-600">
                {{ $errors->first('points') }}
            </p>
        </div>

        <div>
            <input type="hidden" name="isInFavor" value="1">
            <input type="checkbox"  name="isInFavor" value="0"
                class="w- bg-slate-200 px-3 py-1 rounded-md 
                       placeholder:text-zinc-600 shadow-inner" 
                @if (old('isInFavor') == '0') checked @endif />
            <label for="isInFavor" class="font-medium text-zinc-700">Is against</label>
            <p class="text-sm text-red-600">
                {{ $errors->first('isInFavor') }}
            </p>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-3 py-1 w-fit rounded-md">
            Save
        </button>

        @if (session('statusCreate') !== null)
            <p class="p-4 text-green-600 bg-green-100 rounded-md"> {{ session('statusCreate') }}</p>
        @endif
    </form>

</x-layout>
