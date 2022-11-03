<x-layout>
    <x-slot name="title">Updating score</x-slot>
    <div class="flex flex-col items-center pt-6 px-8 flex-grow">
        <div class="flex flex-row justify-between w-full">
            <p class="text-2xl text-zinc-800 font-semibold mb-6 w-full">Points</p>
            <form action="/eventManagement" method="GET">
                <button class="text-xl font-semibold underline text-zinc-800 hover:cursor-pointer">Back</button>
            </form>
        </div>
        @if ($event->result()->result_type_id == 1)
            <x-results.by-mark-table :result="$event->result()"/>
        @endif
        @if ($event->result()->result_type_id == 2)
            {{-- AGREGAR COMPONENTE PARA TABLA DE RESULTADO POR PUNTOS --}}
        @endif
        @if ($event->result()->result_type_id == 3)
            {{-- AGREGAR COMPONENTE PARA TABLA DE RESULTADO POR SETS --}}                
        @endif
        @if (session('statusDelete') && session('deletedId'))
            <x-status-delete-get>
                <x-slot name="action">/mark/{{ session('sideDeleted') }}/restore/{{ session('deletedId') }}</x-slot>
            </x-status-delete-get>
        @endif

        @if (session('statusRestore'))
            <x-status-restore />
        @endif
    </div>
    <form action="/mark/create/{{ $event->id }}" method="post" class="bg-slate-50 flex flex-col gap-6 w-80 px-8 py-6">
        @csrf
        @if ($event->isIndividual())
            <div class="flex flex-col gap-1">
                <label for="playerId" class="font-medium text-zinc-700">Player</label>
                <select name="playerId" id="playerId" class="w-64 bg-slate-200 px-3 py-1 rounded-md shadow-inner" autocomplete="off">
                    <option value="" selected disabled>Select player</option>
                    @foreach($event->opponents() as $player)
                        <option value="{{ $player->id }}">{{ $player->name }} {{ $player->surname }}</option>
                    @endforeach
                </select>
                <p class="text-sm text-red-600">{{ $errors->first('playerId') }}</p>
            </div>
        @else
            <div class="flex flex-col gap-1">
                <label for="teamId" class="font-medium text-zinc-700">Player</label>
                <select name="teamId" id="teamId" class="w-64 bg-slate-200 px-3 py-1 rounded-md shadow-inner">
                    @foreach($event->opponents() as $team)
                        <option value="{{ $team->id }}">{{ $team->name }} {{ $team->surname }}</option>
                    @endforeach
                </select>
                <p class="text-sm text-red-600">{{ $errors->first('teamId') }}</p>
            </div>
        @endif
        @if ($event->result()->result_type_id == $resultTypes['byMark'])
            <div class="flex flex-col gap-1">
                <label for="markValue" class="font-medium text-zinc-700">Value of {{ $event->result()->markName->name }}</label>
                <div>
                    <input type="text" name="markValue" id="markValue" placeholder="Enter mark value" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                    <p class="text-sm text-zinc-600">Do not add units.</p>
                </div>
                <p class="text-sm text-red-600">{{ $errors->first('markValue') }}</p>
            </div>
        @endif
        @if ($event->result()->result_type_id == $resultTypes['byPoints'])
            <div class="flex flex-col gap-1">
                <label for="points" class="font-medium text-zinc-700">Points</label>
                <input type="number" name="points" id="points" min="1" placeholder="Enter amount of points" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                <p class="text-sm text-red-600">{{ $errors->first('points') }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <label for="isInFavor" class="font-medium text-zinc-700">In favor?</label>
                <select name="isInFavor" id="isInFavor" class="w-64 bg-slate-200 px-3 py-1 rounded-md shadow-inner" autocomplete="off">
                    <option value="true" selected>Yes</option>
                    <option value="false">No</option>
                </select>
                <p class="text-sm text-red-600">{{ $errors->first('isInFavor') }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <label for="minute" class="font-medium text-zinc-700">Minute</label>
                <input type="number" name="minute" id="minute" min="0" placeholder="Enter minute" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                <p class="text-sm text-red-600">{{ $errors->first('minute') }}</p>
            </div>
        @endif
        @if ($event->result()->result_type_id == $resultTypes['bySets'])
            <div class="flex flex-col gap-1">
                <label for="points" class="font-medium text-zinc-700">Points</label>
                <input type="number" name="points" id="points" min="1" placeholder="Enter amount of points" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                <p class="text-sm text-red-600">{{ $errors->first('points') }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <label for="isInFavor" class="font-medium text-zinc-700">In favor?</label>
                <select name="isInFavor" id="isInFavor" class="w-64 bg-slate-200 px-3 py-1 rounded-md shadow-inner" autocomplete="off">
                    <option value="1" selected>Yes</option>
                    <option value="0">No</option>
                </select>
                <p class="text-sm text-red-600">{{ $errors->first('isInFavor') }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <label for="minute" class="font-medium text-zinc-700">Minute</label>
                <input type="number" name="minute" id="minute" min="0" placeholder="Enter minute" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                <p class="text-sm text-red-600">{{ $errors->first('minute') }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <label for="set" class="font-medium text-zinc-700">Set</label>
                <select name="set" id="set" class="w-64 bg-slate-200 px-3 py-1 rounded-md shadow-inner" autocomplete="off">
                    <option value="" selected disabled>Select set</option>
                    @for ($i = 1; $i < ($event->result()->set_amount + 1); $i++)
                        <option value="{{ $i }}">{{ $i }}</option>                            
                    @endfor
                </select>
            </div>
        @endif
        <button class="bg-blue-600 text-white px-3 py-1 w-fit rounded-md" type="submit">Save</button>
    </form>
</x-layout>
