<div>
    <div class="flex flex-col gap-1">
        <label for="playerLocalId" class="font-medium text-zinc-700">Local player</label>
        <select name="playerLocalId" wire:model="chosenLocal" id="playerLocalId" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
            <option value="{{ $local->id }}"selected>{{ $local->name }} {{ $local->surname }}</option>
            @foreach ($locals as $player)
                <option value="{{ $player->id }}">{{ $player->name }} {{ $player->surname }}</option>
            @endforeach
        </select>
        <p class="text-sm text-red-600">{{ $errors->first('playerLocalId') }}</p>
    </div>
    <div class="flex flex-col gap-1">
        <label for="playerVisitorId" class="font-medium text-zinc-700">Visitor player</label>
        <select name="playerVisitorId" wire:model="chosenVisitor" id="playerVisitorId" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
            <option value="{{ $visitor->id }}"selected>{{ $visitor->name }} {{ $visitor->surname }}</option>
            @foreach ($visitors as $player)
                <option value="{{ $player->id }}">{{ $player->name }} {{ $player->surname }}</option>
            @endforeach
        </select>
        <p class="text-sm text-red-600">{{ $errors->first('playerVisitorId') }}</p>
    </div>
</div>
