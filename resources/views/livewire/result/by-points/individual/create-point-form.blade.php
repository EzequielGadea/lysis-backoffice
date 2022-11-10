<form action="/points/team/create/{{ $result->id }}" method="post"
    class="bg-slate-50 flex flex-col gap-6 w-80 px-8 py-6">
    @csrf

    <div class="flex flex-col gap-1">
        <label for="team" class="font-medium text-zinc-700">
            Team
        </label>
        <select name="team" wire:model="team" autocomplete="off"
            class="w-64 bg-slate-200 px-3 py-1 rounded-md shadow-inner">
            <option value="" selected>-- Choose team --</option>
            @foreach ($teams as $team)
                <option value="{{ $team->id ?? $team['id'] }}">{{ $team->name ?? $team['name'] }}</option>
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
        <select name="player" wire:model="player" autocomplete="off"
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

    <div class="flex flex-col gap-1">
        <label for="minute" class="font-medium text-zinc-700">
            Minute
        </label>
        <input type="number" wire:model="minute" name="minute" placeholder="Enter minute"
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
        <input type="number" wire:model="points" name="points" placeholder="Enter amount of points"
            class="w-64 bg-slate-200 px-3 py-1 rounded-md 
                 placeholder:text-zinc-600 shadow-inner" />
        <p class="text-sm text-red-600">
            {{ $errors->first('points') }}
        </p>
    </div>

    <div>
        <input type="hidden" name="isInFavor" value="1">
        <input type="checkbox" wire:model="isInFavor" name="isInFavor" value="0"
            class="w- bg-slate-200 px-3 py-1 rounded-md 
                   placeholder:text-zinc-600 shadow-inner" />
        <label for="isInFavor" class="font-medium text-zinc-700">Is against</label>
        <p class="text-sm text-red-600">
            {{ $errors->first('point') }}
        </p>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-3 py-1 w-fit rounded-md">
        Save
    </button>

    @if (session('statusCreate') !== null)
        <p class="p-4 text-green-600 bg-green-100 rounded-md"> {{ session('statusCreate') }}</p>
    @endif
</form>
