<x-layout>
    <x-slot name="title">Updating player...</x-slot>
    <x-update-card>
        <x-slot name="action">playerTeamUpdate</x-slot>
        <x-slot name="backTo">playerTeamManagement/{{ $playerTeam->team_id }}</x-slot>
        <input type="hidden" name="playerTeamId" value="{{ $playerTeam->id }}">
        <div class="flex flex-col gap-1">
            <p class="font-medium text-zinc-700">Player</p>
            <p class="w-64 bg-slate-200 px-3 py-1 rounded-md shadow-inner">
                {{ $playerTeam->player->name }} {{ $playerTeam->player->surname }}
            </p>
            <p class="text-sm text-red-600">{{ $errors->first('contractStart') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="position" class="font-medium text-zinc-700">Position</label>
            <select name="positionId" id="position" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                <option disabled>Choose position</option>
                @foreach ($positions as $position)
                    @if ($position->id == $playerTeam->position_id)
                        <option value="{{ $position->id }}" selected>{{ $position->name }}</option>
                    @else
                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                    @endif
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('positionId') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="shirtNumber" class="font-medium text-zinc-700">Shirt number</label>
            <input type="number" name="shirtNumber" id="shirtNumber" placeholder="Enter shirtNumber" value="{{ $playerTeam->shirt_number }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('shirtNumber') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="contractStart" class="font-medium text-zinc-700">Contract start</label>
            <input type="date" name="contractStart" id="contractStart" placeholder="Enter contractStart" value="{{ $playerTeam->contract_start }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('contractStart') }}</p>
        </div>
    </x-update-card>
</x-layout>