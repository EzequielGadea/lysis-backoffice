<div class="flex flex-col gap-12">
    @if ($result->event->isIndividual())
        <div class="rounded-md overflow-x-auto shadow-xl w-[50rem]">
            <table class="table-auto border-collapse w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-300">
                        <td class="p-3 font-light text-zinc-800">ID</td>
                        <td class="p-3 font-light text-zinc-800">MARK NAME</td>
                        <td class="p-3 font-light text-zinc-800">VALUE</td>
                        <td class="p-3 font-light text-zinc-800">MARK CRITERIA</td>
                        <td class="p-3 font-light text-zinc-800">PLAYER</td>
                        <td class="p-3 font-light text-zinc-800">AS</td>
                        <td class="p-3 font-light text-zinc-800 text-center">ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($result->marksPlayerVisitor()->get()->sortBy([['mark_value', $result->markName->criteria->sort_by]]) as $mark)
                        <tr class="border-b border-slate-300">
                            <td class="p-3 text-zinc-800">{{ $mark->id }}</td>
                            <td class="p-3 text-zinc-800">{{ $result->markName->name }}</td>
                            <td class="p-3 text-zinc-800">{{ $mark->mark_value }}{{ $mark->result->markName->unit->unit }}</td>
                            <td class="p-3 text-zinc-800">{{ $result->markName->criteria->name }}</td>
                            <td class="p-3 text-zinc-800">
                                <div class="flex flex-row gap-4 items-center">
                                    <img src="{{ asset('images/' . $mark->playerVisitor->player->picture) }}" 
                                         alt="{{ $mark->player->name ?? $mark->playerVisitor->player->name }} {{ $mark->player->surname ?? $mark->playerVisitor->player->surname }}"
                                        class="h-16 w-16 rounded-full shadow-md bg-center"/>
                                    <p>
                                        {{ $mark->playerVisitor->player->name }} {{ $mark->playerVisitor->player->surname }}
                                    </p>
                                </div>
                            </td>
                            <td class="p-3 text-zinc-800">
                                @if ($mark->getTable() == 'by_mark_player_visitor')
                                    <p>Visitor</p>
                                @else
                                    <p>Local</p>
                                @endif
                            </td>
                            <td class="p-3 text-zinc-800">
                                <div class="flex flex-col items-center">
                                    <form action="/mark/visitor/update/{{ $mark->id }}" method="GET">
                                        <button class="font-semibold text-blue-600">Edit</button>
                                    </form>
                                    <form action="/mark/visitor/delete/{{ $mark->id }}" method="post">
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
        <div class="rounded-md overflow-x-auto shadow-xl w-[50rem]">
            <table class="table-auto border-collapse w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-300">
                        <td class="p-3 font-light text-zinc-800">ID</td>
                        <td class="p-3 font-light text-zinc-800">MARK NAME</td>
                        <td class="p-3 font-light text-zinc-800">VALUE</td>
                        <td class="p-3 font-light text-zinc-800">MARK CRITERIA</td>
                        <td class="p-3 font-light text-zinc-800">PLAYER</td>
                        <td class="p-3 font-light text-zinc-800">AS</td>
                        <td class="p-3 font-light text-zinc-800 text-center">ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($result->marksPlayerLocal()->get()->sortBy([['mark_value', $result->markName->criteria->sort_by]]) as $mark)
                        <tr class="border-b border-slate-300">
                            <td class="p-3 text-zinc-800">{{ $mark->id }}</td>
                            <td class="p-3 text-zinc-800">{{ $result->markName->name }}</td>
                            <td class="p-3 text-zinc-800">{{ $mark->mark_value }}{{ $mark->result->markName->unit->unit }}</td>
                            <td class="p-3 text-zinc-800">{{ $result->markName->criteria->name }}</td>
                            <td class="p-3 text-zinc-800">
                                <div class="flex flex-row gap-4 items-center">
                                    <img src="{{ asset('images/' . $mark->playerLocal->player->picture) }}" 
                                    alt="{{ $mark->playerLocal->player->name }} {{ $mark->playerLocal->player->surname }}"
                                   class="h-16 w-16 rounded-full shadow-md bg-center"/>
                                   <p>
                                       {{ $mark->playerLocal->player->name }} {{ $mark->playerLocal->player->surname }}
                                   </p>
                                </div>
                            </td>
                            <td class="p-3 text-zinc-800">
                                @if ($mark->getTable() == 'by_mark_player_visitor')
                                    <p>Visitor</p>
                                @else
                                    <p>Local</p>
                                @endif
                            </td>
                            <td class="p-3 text-zinc-800">
                                <div class="flex flex-col items-center">
                                    <form action="/mark/local/update/{{ $mark->id }}" method="GET">
                                        <button class="font-semibold text-blue-600">Edit</button>
                                    </form>
                                    <form action="/mark/local/delete/{{ $mark->id }}" method="post">
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
    @endif
</div>
