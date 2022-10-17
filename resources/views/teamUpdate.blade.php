<x-layout>
    <x-slot name="title">Updating team...</x-slot>
    <x-update-card>
        <x-slot name="action">teamUpdate</x-slot>
        <x-slot name="backTo">teamManagement</x-slot>
        <input type="hidden" name="id" value="{{ $team->id }}">
        <div class="flex flex-col gap-1">
            <label for="name" class="font-medium text-zinc-700">Name</label>
            <input type="text" name="name" id="name" value="{{ $team->name }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('name') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="countryId" class="font-medium text-zinc-700">Country</label>
            <select name="countryId" id="countryId" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                <option disabled>Choose a country</option>
                @foreach($countries as $country)
                    @if($country->id == $team->country_id)
                        <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                    @else
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endif
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('countryId') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="managerId" class="font-medium text-zinc-700">Manager</label>
            <select name="managerId" id="managerId" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                <option disabled selected>Choose a manager</option>
                @foreach($managers as $manager)
                    @if($manager->id == $team->manager_id)
                        <option value="{{ $manager->id }}" selected>{{ $manager->name }} {{ $manager->surname }}</option>
                    @else
                        <option value="{{ $manager->id }}">{{ $manager->name }} {{ $manager->surname }}</option>
                    @endif
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('managerId') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="leagueId" class="font-medium text-zinc-700">League</label>
            <select name="leagueId" id="leagueId" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                <option disabled selected>Choose a manager</option>
                @foreach($leagues as $league)
                    @if($league->id == $team->league_id)
                        <option value="{{ $league->id }}" selected>{{ $league->name }}</option>
                    @else
                        <option value="{{ $league->id }}">{{ $league->name }}</option>
                    @endif
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('leagueId') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="logoLink" class="font-medium text-zinc-700">Logo link</label>
            <input type="text" name="logoLink" id="logoLink" placeholder="Enter link" value="{{ $team->logo_link }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('logoLink') }}</p>
        </div>
    </x-update-card>
</x-layout>