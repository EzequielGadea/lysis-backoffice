<x-layout>
    <x-slot name="title">Updating mark...</x-slot>
    <x-update-card>
        <x-slot name="action">mark/team/update/{{ $mark->id }}</x-slot>
        <x-slot name="backTo">mark/team/index/{{ $mark->result->event->id }}</x-slot>
        <div class="flex flex-col gap-1">
            <label for="mark_value" class="font-medium text-zinc-700">
                Value of {{ $mark->result->markName->name }} ({{ $mark->result->markName->unit->name }})
            </label>
            <input type="text" name="mark_value" value="{{ $mark->mark_value }}" 
                   class="w-64 bg-slate-200 px-3 py-1 rounded-md 
                   placeholder:text-zinc-600 shadow-inner" />
            <p class="text-sm text-zinc-600">Do not add units.</p>
            <p class="text-sm text-red-600">{{ $errors->first('mark_value') }}</p>
        </div>
    </x-update-card>
</x-layout>
