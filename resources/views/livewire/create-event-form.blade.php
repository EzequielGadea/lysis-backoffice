<div class="flex flex-col gap-2">
    <div>
        <input type="hidden" name="isIndividual" value="0">
        <input type="checkbox" wire:model='isIndividual' name="isIndividual" value="1" id="isIndividual">
        <label for="isIndividual" class="font-medium text-zinc-700">Is individual</label>
        <p class="text-sm text-red-600">{{ $errors->first('isIndividual') }}</p>
    </div>
    @if ($isIndividual)
        <div>
            <div class="flex flex-col gap-1">
                <label for="playerLocalId" class="font-medium text-zinc-700">Local player</label>
                <select name="playerLocalId" wire:model="chosenLocalPlayer" id="playerLocalId"
                    class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                    <option selected>-- Choose player --</option>
                    @foreach ($localPlayers as $player)
                        <option value="{{ $player->id }}" @if (old('playerLocalId') == $player->id) selected @endif>
                            {{ $player->name }} {{ $player->surname }}
                        </option>
                    @endforeach
                </select>
                <p class="text-sm text-red-600">{{ $errors->first('playerLocalId') }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <label for="playerVisitorId" class="font-medium text-zinc-700">Visitor player</label>
                <select name="playerVisitorId" wire:model="chosenVisitorPlayer" id="playerVisitorId"
                    class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                    <option selected>-- Choose player --</option>
                    @foreach ($visitorPlayers as $player)
                        <option value="{{ $player->id }}" @if (old('playerVisitorId') == $player->id) selected @endif>
                            {{ $player->name }} {{ $player->surname }}
                        </option>
                    @endforeach
                </select>
                <p class="text-sm text-red-600">{{ $errors->first('playerVisitorId') }}</p>
            </div>
        </div>
    @else
        <div>
            <div class="flex flex-col gap-1">
                <label for="teamLocalId" class="font-medium text-zinc-700">Local team</label>
                <select name="teamLocalId" wire:model="chosenLocalTeam" id="teamLocalId"
                    class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner"
                    autocomplete="off">
                    <option selected>-- Choose team --</option>
                    @foreach ($localTeams as $team)
                        <option value="{{ $team->id }}" @if (old('teamLocalId') == $team->id) selected @endif>
                            {{ $team->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-sm text-red-600">{{ $errors->first('teamLocalId') }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <label for="teamVisitorId" class="font-medium text-zinc-700">Visitor team</label>
                <select name="teamVisitorId" wire:model="chosenVisitorTeam" id="teamVisitorId"
                    class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner"
                    autocomplete="off">
                    <option selected>-- Choose team --</option>
                    @foreach ($visitorTeams as $team)
                        <option value="{{ $team->id }}" @if (old('teamVisitorId') == $team->id) selected @endif>
                            {{ $team->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-sm text-red-600">{{ $errors->first('teamVisitorId') }}</p>
            </div>
        </div>
    @endif
</div>
