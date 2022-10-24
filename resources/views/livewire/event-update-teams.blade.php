<div>
    <div class="flex flex-col gap-1">
        <label for="teamLocalId" class="font-medium text-zinc-700">Local team</label>
        <select name="teamLocalId" wire:model="chosenLocalTeam" id="teamLocalId" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
            <option selected>Choose team</option>
            @foreach ($localTeams as $team)
                <option value="{{ $team->id }}">{{ $team->name }}</option>
            @endforeach
        </select>
        <p class="text-sm text-red-600">{{ $errors->first('teamLocalId') }}</p>
    </div>
    <div class="flex flex-col gap-1">
        <label for="teamVisitorId" class="font-medium text-zinc-700">Visitor team</label>
        <select name="teamVisitorId" wire:model="chosenVisitorTeam" id="teamVisitorId" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
            <option selected>Choose team</option>
            @foreach ($visitorTeams as $team)
                <option value="{{ $team->id }}">{{ $team->name }}</option>
            @endforeach
        </select>
        <p class="text-sm text-red-600">{{ $errors->first('teamVisitorId') }}</p>
    </div>
</div>
