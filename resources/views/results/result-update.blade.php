<x-layout>
    <x-slot name="title">Updating result</x-slot>
    <x-update-card>
        @if ($playerMark->getTable() == 'by_mark_player_local')
            <x-slot name="action">mark/local/update/{{ $playerMark->id }}</x-slot>
        @else
            <x-slot name="action">mark/visitor/update/{{ $playerMark->id }}</x-slot>
        @endif
        <x-slot name="backTo">mark/management/{{ $playerMark->event->id }}</x-slot>
        <div class="flex flex-col gap-1">
            <label for="markValue" class="font-medium text-zinc-700">Value of {{ $playerMark->result->markName->name ?? 'no hay' }}</label>
            <div>
                <input type="text" name="markValue" id="markValue" placeholder="Enter mark value" value="{{ $playerMark->mark_value }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                <p class="text-sm text-zinc-600">Do not add units.</p>
            </div>
            <p class="text-sm text-red-600">{{ $errors->first('markValue') }}</p>
        </div>
    </x-update-card>
</x-layout>