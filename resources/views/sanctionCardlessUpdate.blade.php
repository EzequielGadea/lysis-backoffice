<x-layout>
    <x-slot name="title">Updating sanction...</x-slot>
    <x-update-card>
        <x-slot name="action">sanctionCardlessUpdate</x-slot>
        <x-slot name="backTo">sanctionCardlessManagement</x-slot>
        <input type="hidden" name="id" value="{{ $sanction->id }}">
        <div class="flex flex-col gap-1">
            <label for="description" class="font-medium text-zinc-700">Description</label>
            <input type="text" name="description" id="description" value="{{ $sanction->description }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('description') }}</p>
        </div>
    </x-update-card>
</x-layout>