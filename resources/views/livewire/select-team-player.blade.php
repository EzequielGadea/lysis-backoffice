<div>
    <div class="flex flex-col gap-1">
        <label for="team" class="font-medium text-zinc-700">
            Team
        </label>
        <select name="team" wire:model="team" autocomplete="off"
            class="w-64 bg-slate-200 px-3 py-1 rounded-md shadow-inner">
            <option value="" selected>-- Choose team --</option>
            @foreach ($teams as $team)
                <option value="{{ $team->id }}">{{ $team->name }}</option>
            @endforeach
        </select>
        <p class="text-sm text-red-600">
            {{ $errors->first('team') }}
        </p>
    </div>

    <div class="flex flex-col gap-1">
        <label for="player" class="font-medium text-zinc-700">
            Player
        </label>
        <select name="player" autocomplete="off"
            class="w-64 bg-slate-200 px-3 py-1 rounded-md shadow-inner">
            <option value="">-- choose player --</option>
            @foreach ($players as $player)
                <option value="{{ $player->id }}">
                    {{ $player->name }} {{ $player->surname }}
                </option>
            @endforeach
        </select>
        <p class="text-sm text-red-600">
            {{ $errors->first('player') }}
        </p>
    </div>
</div>

