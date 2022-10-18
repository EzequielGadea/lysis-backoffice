<x-layout>
    <x-slot name="title">Updating country...</x-slot>
    <x-update-card>
        <x-slot name="action">countryUpdate</x-slot>
        <x-slot name="backTo">countryManagement</x-slot>
        <input type="hidden" name="id" value="{{ $country->id }}">
        <div class="flex flex-col gap-1">
            <label for="name" class="font-medium text-zinc-700">Name</label>
            <input type="text" name="name" id="name" value="{{ $country->name }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('name') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="countryFlagLink" class="font-medium text-zinc-700">Country flag link</label>
            <input type="text" name="countryFlagLink" id="countryFlagLink" value="{{ $country->country_flag_link }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('countryFlagLink') }}</p>
        </div>
    </x-update-card>
</x-layout>