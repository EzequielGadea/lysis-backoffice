<x-layout>
    <x-slot name="title">Event management</x-slot>
    <x-nav />
    <div class="flex flex-col items-center pt-6 px-8 w-[50rem] flex-grow">
        <p class="text-2xl text-zinc-800 font-semibold mb-6 w-full">Events</p>
        <div class="rounded-md overflow-x-auto shadow-xl w-full">
            <table class="table-auto border-collapse whitespace-nowrap w-full">
                <thead>
                    <tr class="bg-slate-300">
                        <td class="p-3 font-light text-zinc-800">ID</td>
                        <td class="p-3 font-light text-zinc-800">START DATE</td>
                        <td class="p-3 font-light text-zinc-800">VENUE</td>
                        <td class="p-3 font-light text-zinc-800">OPPONENTS</td>
                        <td class="p-3 font-light text-zinc-800">RESULT</td>
                        <td class="p-3 font-light text-zinc-800">LEAGUE</td>
                        <td class="p-3 font-light text-zinc-800">SPORT</td>
                        <td class="p-3 font-light text-zinc-800">CREATED AT</td>
                        <td class="p-3 font-light text-zinc-800">UPDATED AT</td>
                        <td class="p-3 font-light text-zinc-800 text-center">ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($events))
                        @foreach ($events as $event)
                            <tr class="border-b border-slate-300">
                                <td class="p-3 text-zinc-800 text-right">{{ $event->id }}</td>
                                <td class="p-3 text-zinc-800">{{ $event->start_date }}</td>
                                <td class="p-3 text-zinc-800">{{ $event->venue->name }}</td>
                                <td class="p-3 text-zinc-800 text-center">
                                    <p>
                                        {{ $event->playerVisitor->player->name ?? ($event->teamVisitor->team->name ?? '') }}
                                        {{ $event->playerVisitor ? $event->playerVisitor->player->surname : '' }}
                                        (V)
                                    </p>
                                    <p class="font-semibold text-zinc-800">vs</p>
                                    <p>
                                        {{ $event->playerLocal->player->name ?? ($event->teamLocal->team->name ?? '') }}
                                        {{ $event->playerLocal ? $event->playerLocal->player->surname : '' }}
                                        (L)
                                    </p>
                                </td>
                                <td class="p-3 text-zinc-800">{{ $event->result()->type->name ?? 'no tiene' }}</td>
                                <td class="p-3 text-zinc-800">{{ $event->league->name }}</td>
                                <td class="p-3 text-zinc-800">{{ $event->league->sport->name }}</td>
                                <td class="p-3 text-zinc-800">{{ $event->created_at }}</td>
                                <td class="p-3 text-zinc-800">{{ $event->updated_at }}</td>
                                <td class="p-3 text-zinc-800">
                                    <div class="flex flex-col items-center">
                                        <form action="eventUpdate/{{ $event->id }}" method="GET">
                                            <button class="font-semibold text-blue-600">Edit</button>
                                        </form>
                                        <form action="eventDelete/{{ $event->id }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button class="font-semibold text-blue-600" type="submit">Delete</button>
                                        </form>
                                        @if ($event->result()->result_type_id == '1')
                                            @if ($event->isIndividual())
                                                <form action="/mark/management/{{ $event->id }}" method="GET">
                                                    @csrf
                                                    <button class="font-semibold text-blue-600"
                                                        type="submit">Results</button>
                                                </form>
                                            @else
                                                <form action="/mark/team/index/{{ $event->id }}" method="get">
                                                    <button class="font-semibold text-blue-600"
                                                        type="submit">Results</button>
                                                </form>
                                            @endif
                                        @endif
                                        @if ($event->result()->result_type_id == '2')
                                            @if ($event->isIndividual())
                                                <form action="/points/individual/index/{{ $event->id }}"
                                                    method="get">
                                                    <button type="submit"
                                                        class="font-semibold text-blue-600">Results</button>
                                                </form>
                                            @else
                                                <form action="/points/team/index/{{ $event->id }}" method="get">
                                                    <button type="submit"
                                                        class="font-semibold text-blue-600">Results</button>
                                                </form>
                                            @endif
                                        @endif
                                        @if ($event->result()->result_type_id == '3')
                                            @if ($event->isIndividual())
                                                <form action="/set/individual/index/{{ $event->id }}"
                                                    method="get">
                                                    <button type="submit"
                                                        class="font-semibold text-blue-600">Results</button>
                                                </form>
                                            @else
                                                <form action="/set/team/index/{{ $event->id }}" method="get">
                                                    <button class="font-semibold text-blue-600"
                                                        type="submit">Results</button>
                                                </form>
                                            @endif
                                        @endif
                                        <form action="/sanctions/cardless/individual/index/{{ $event->id }}"
                                            method="get">
                                            <button class="font-semibold text-blue-600"
                                                type="submit">Cardless sanctions</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        @if (session('statusDelete') && session('deletedId'))
            <x-status-delete>
                <x-slot name="action">eventRestore</x-slot>
                <x-slot name="id">{{ session('deletedId') }}</x-slot>
            </x-status-delete>
        @endif
        @if (session('statusRestore'))
            <x-status-restore />
        @endif
    </div>
    <x-create-section>
        <x-slot name="action">eventRegister</x-slot>
        <div class="flex flex-col gap-1">
            <label for="startDate" class="font-medium text-zinc-700">Start date</label>
            <input type="datetime-local" name="startDate" id="startDate" value="{{ old('startDate') }}"
                class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('startDate') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="leagueId" class="font-medium text-zinc-700">League</label>
            <select name="leagueId" id="leagueId"
                class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                <option value="" disabled>-- Choose league --</option>
                @foreach ($leagues as $league)
                    <option value="{{ $league->id }}" @if (old('leagueId') == $league->id) selected @endif>
                        {{ $league->name }}
                    </option>
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('leagueId') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="venueId" class="font-medium text-zinc-700">Venue</label>
            <select name="venueId" id="venueId"C
                class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                <option selected disabled>-- Choose venue --</option>
                @foreach ($venues as $venue)
                    <option value="{{ $venue->id }}" @if (old('venueId') == $venue->id) selected @endif>{{ $venue->name }}</option>
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('venueId') }}</p>
        </div>
        @livewire('create-event-form')
        @livewire('events.create-event-result-form', [
            'resultTypes' => $resultTypes,
            'markNames' => $markNames,
        ])
    </x-create-section>
</x-layout>
