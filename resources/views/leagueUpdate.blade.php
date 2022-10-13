<x-layout>
    <x-slot name="title">Updating league...</x-slot>
    <x-update-card>
        <x-slot name="action">leagueUpdate</x-slot>
        <x-slot name="backTo">leagueManagement</x-slot>
        <input type="hidden" name="id" value="{{ $league->id }}">
        <div class="flex flex-col gap-1">
            <label for="name" class="font-medium text-zinc-700">Name</label>
            <input type="text" name="name" id="name" value="{{ $league->name }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('name') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="logoLink" class="font-medium text-zinc-700">Logo link</label>
            <input type="text" name="logoLink" id="logoLink" placeholder="Enter name" value="{{ $league->logo_link }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('logoLink') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="sport" class="font-medium text-zinc-700">Sport</label>
            <select name="sportId" id="sport" autocomplete="off" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                @foreach ($sports as $sport)
                    @if($sport->id == $league->sport_id)
                        <option value="{{ $sport->id }}" selected>{{ $sport->name }}</option>
                    @else
                        <option value="{{ $sport->id }}">{{ $sport->name }}</option>
                    @endif
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('sportId') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="country" class="font-medium text-zinc-700">Country</label>
            <select name="countryId" id="country" autocomplete="off" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                <option disabled selected>Select a country</option>
                @foreach ($countries as $country)
                    @if($country->id == $league->country_id)
                        <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                    @else
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endif
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('countryId') }}</p>
        </div>
    </x-update-card>
</x-layout>