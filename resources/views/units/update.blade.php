<x-layout>
    <x-slot name="title">Updating unit...</x-slot>
    <x-update-card>
        <x-slot name="action">unit/update/{{ $unit->id }}</x-slot>
        <x-slot name="backTo">unit/index</x-slot>
        <div class="flex flex-col gap-1">
            <label for="name" class="font-medium text-zinc-700">Start date</label>
            <input type="text" placeholder="Enter unit name" name="name" id="name" value="{{ $unit->name }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('name') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="unit" class="font-medium text-zinc-700">unit</label>
            <input type="text" placeholder="Enter measurement units" name="unit" id="unit" value="{{ $unit->unit }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('unit') }}</p>
        </div>
    </x-update-card>
</x-layout>