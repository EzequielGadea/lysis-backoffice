<x-layout>
    <x-slot name="title">Managing score</x-slot>
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
                            <td class="p-3 font-light text-zinc-800">PLAYER (L)</td>
                            <td class="p-3 font-light text-zinc-800">CREATED AT</td>
                            <td class="p-3 font-light text-zinc-800">UPDATED AT</td>
                            <td class="p-3 font-light text-zinc-800 text-center">ACTIONS</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event->result()->sets as $set)
                            @foreach ($set->playerLocalPoints->sortBy([['set.number', 'asc'], ['minute', 'asc']]) as $point)
                                <tr class="border-b border-slate-300">
                                    <td class="p-3 text-zinc-800">{{ $point->id }}</td>
                                    <td class="p-3 text-zinc-800">Set {{ $set->number }}</td>
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
                                            <div style="background-image: url({{ asset('images/' . $point->player()->picture) }})"
                                                class="h-16 w-16 rounded-full shadow-md bg-center bg-contain 
                                                whitespace-nowrap overflow-hidden bg-no-repeat bg-origin-border 
                                                bg-clip-padding">
                                            </div>
                                            <p>
                                                {{ $point->player()->name ?? '' }}
                                                {{ $point->player()->surname }}
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
                                            <form action="/set/individual/local/edit/{{ $point->id }}"
                                                method="GET">
                                                <button class="font-semibold text-blue-600">Edit</button>
                                            </form>
                                            <form action="/set/individual/local/delete/{{ $point->id }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button class="font-semibold text-blue-600">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="rounded-md overflow-x-auto shadow-xl w-[75rem]">
                <table class="table-auto border-collapse w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-300">
                            <td class="p-3 font-light text-zinc-800">ID</td>
                            <td class="p-3 font-light text-zinc-800">SET</td>
                            <td class="p-3 font-light text-zinc-800">MIN</td>
                            <td class="p-3 font-light text-zinc-800">POINTS</td>
                            <td class="p-3 font-light text-zinc-800">PLAYER (V)</td>
                            <td class="p-3 font-light text-zinc-800">CREATED AT</td>
                            <td class="p-3 font-light text-zinc-800">UPDATED AT</td>
                            <td class="p-3 font-light text-zinc-800 text-center">ACTIONS</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event->result()->sets as $set)
                            @foreach ($set->playerVisitorPoints->sortBy([['set.number', 'asc'], ['minute', 'asc']]) as $point)
                                <tr class="border-b border-slate-300">
                                    <td class="p-3 text-zinc-800">{{ $point->id }}</td>
                                    <td class="p-3 text-zinc-800">Set {{ $set->number }}</td>
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
                                            <div style="background-image: url({{ asset('images/' . $point->player()->picture) }})"
                                                class="h-16 w-16 rounded-full shadow-md bg-center bg-contain 
                                                whitespace-nowrap overflow-hidden bg-no-repeat bg-origin-border 
                                                bg-clip-padding">
                                            </div>
                                            <p>
                                                {{ $point->player()->name ?? '' }}
                                                {{ $point->player()->surname }}
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
                                            <form action="/set/individual/visitor/edit/{{ $point->id }}"
                                                method="GET">
                                                <button class="font-semibold text-blue-600">Edit</button>
                                            </form>
                                            <form action="/set/individual/visitor/delete/{{ $point->id }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button class="font-semibold text-blue-600">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if (session('statusDelete') && session('deletedId'))
            <x-status-delete-get>
                <x-slot name="action">/set/individual/{{ session('side') }}/restore/{{ session('deletedId') }}
                </x-slot>
            </x-status-delete-get>
        @endif

        @if (session('statusRestore'))
            <x-status-restore />
        @endif
    </div>
    <form action="/set/individual/create/{{ $event->result()->id }}" method="post"
        class="bg-slate-50 flex flex-col gap-6 w-80 px-8 py-6" name="ads">
        @csrf

        <div class="flex flex-col gap-1">
            <label for="player" class="font-medium text-zinc-700">
                Player
            </label>
            <select name="player" autocomplete="off" class="w-64 bg-slate-200 px-3 py-1 rounded-md shadow-inner">
                <option value="">-- choose player --</option>
                @foreach ($event->opponents() as $player)
                    <option value="{{ $player->id }}" @if (old('player') == $player->id) selected @endif>
                        {{ $player->name }} {{ $player->surname }}
                    </option>
                @endforeach
            </select>
            <p class="text-sm text-red-600">
                {{ $errors->first('player') }}
            </p>
        </div>

        <div class="flex flex-col gap-1">
            <label for="set" class="font-medium text-zinc-700">
                Set
            </label>
            <select name="set" autocomplete="off" class="w-64 bg-slate-200 px-3 py-1 rounded-md shadow-inner">
                <option value="" selected>-- Choose set --</option>
                @foreach ($event->result()->sets as $set)
                    <option value="{{ $set->id }}" @if (old('set', 0) == $set->id) selected @endif>
                        {{ $set->number }}
                    </option>
                @endforeach
            </select>
            <p class="text-sm text-red-600">
                {{ $errors->first('set') }}
            </p>
        </div>

        <div class="flex flex-col gap-1">
            <label for="minute" class="font-medium text-zinc-700">
                Minute
            </label>
            <input type="number" name="minute" placeholder="Enter minute" value="{{ old('minute') }}"
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
            <input type="number" name="points" placeholder="Enter amount of points" value="{{ old('points') }}"
                class="w-64 bg-slate-200 px-3 py-1 rounded-md 
                     placeholder:text-zinc-600 shadow-inner" />
            <p class="text-sm text-red-600">
                {{ $errors->first('points') }}
            </p>
        </div>

        <div>
            <input type="hidden" name="isInFavor" value="1">
            <input type="checkbox" name="isInFavor" value="0" @if (old('isInFavor') == '0') checked @endif
                class="w- bg-slate-200 px-3 py-1 rounded-md 
                       placeholder:text-zinc-600 shadow-inner" />
            <label for="isInFavor" class="font-medium text-zinc-700">Point against</label>
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
