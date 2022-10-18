<x-layout>
    <x-slot name="title">Updating venue...</x-slot>
    <x-update-card>
        <x-slot name="action">venueUpdate</x-slot>
        <x-slot name="backTo">venueManagement</x-slot>
        <input type="hidden" name="id" value="{{ $venue->id }}">
        <div class="flex flex-col gap-1">
            <label for="name" class="font-medium text-zinc-700">Name</label>
            <input type="text" name="name" id="name" value="{{ $venue->name }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('name') }}</p>
        </div>
    </x-update-card>
</x-layout>