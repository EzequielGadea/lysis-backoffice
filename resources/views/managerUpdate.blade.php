<x-layout>
    <x-slot name="title">Updating manager...</x-slot>
    <x-update-card>
        <x-slot name="action">managerUpdate</x-slot>
        <x-slot name="backTo">managerManagement</x-slot>
        <input type="hidden" name="id" value="{{ $manager->id }}">
        <div class="flex flex-col gap-1">
            <label for="name" class="font-medium text-zinc-700">Name</label>
            <input type="text" name="name" id="name" value="{{ $manager->name }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('name') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="surname" class="font-medium text-zinc-700">Surname</label>
            <input type="text" name="surname" id="surname" value="{{ $manager->surname }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('surname') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="birthDate" class="font-medium text-zinc-700">Birth date</label>
            <input type="date" name="birthDate" id="birthDate" value="{{ $manager->birth_date }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('birthDate') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="country" class="font-medium text-zinc-700">Country</label>
            <select name="countryId" id="country" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                @foreach($countries as $country)
                    @if($manager->country_id == $country->id)
                        <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                    @else
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endif
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('country') }}</p>
        </div>
    </x-update-card>
</x-layout>