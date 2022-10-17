<x-layout>
    <x-slot name="title">Team management</x-slot>
    <x-nav/>
    <div class="flex flex-col items-center pt-6 px-8 w-[50rem] flex-grow">
        <p class="text-2xl text-zinc-800 font-semibold mb-6 w-full">Teams</p>
        <div class="rounded-md overflow-x-auto shadow-xl w-full">
            <table class="table-auto border-collapse whitespace-nowrap w-full">
                <thead>
                    <tr class="bg-slate-300">
                        <td class="pl-3 px-3 py-3 font-light text-zinc-800">ID</td>
                        <td class="py-3 px-3 font-light text-zinc-800">NAME</td>
                        <td class="py-3 px-3 font-light text-zinc-800">COUNTRY</td>
                        <td class="py-3 px-3 font-light text-zinc-800">LEAGUE</td>
                        <td class="py-3 px-3 font-light text-zinc-800">MANAGER</td>
                        <td class="py-3 px-3 font-light text-zinc-800">LOGO LINK</td>
                        <td class="py-3 px-3 font-light text-zinc-800">CREATED AT</td>
                        <td class="py-3 px-3 font-light text-zinc-800">UPDATED AT</td>
                        <td class="pr-3 px-3 py-3 font-light text-zinc-800 text-center">ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($teams))
                        @foreach ($teams as $team)
                            <tr class="border-b border-slate-300">
                                <td class="pl-3 px-3 text-zinc-800">{{ $team->id }}</td>
                                <td class="py-3 px-3 text-zinc-800">{{ $team->name }}</td>
                                <td class="py-3 px-3 text-zinc-800">{{ $team->country }}</td>
                                <td class="py-3 px-3 text-zinc-800">{{ $team->league }}</td>
                                <td class="py-3 px-3 text-zinc-800">{{ $team->managerName }} {{ $team->managerSurname }}</td>
                                <td class="py-3 px-3 text-zinc-800">{{ $team->logo_link }}</td>
                                <td class="py-3 px-3 text-zinc-800">{{ $team->created_at }}</td>
                                <td class="py-3 px-3 text-zinc-800">{{ $team->updated_at }}</td>
                                <td class="pr-3 px-3 text-zinc-800">
                                    <div class="flex flex-col items-center">
                                        <form action="teamUpdate/{{ $team->id }}" method="GET">
                                            <button class="font-semibold text-blue-600">Edit</button>
                                        </form>
                                        <form action="teamDelete" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $team->id }}">
                                            <button class="font-semibold text-blue-600" type="submit">Delete</button>
                                        </form>
                                        <form action="teamUpdatePlayers">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $team->id }}">
                                            <button class="font-semibold text-blue-600" type="submit">Players</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        @if(session('statusDelete') && session('deletedId'))
            <x-status-delete>
                <x-slot name="action">teamRestore</x-slot>
                <x-slot name="id">{{ session('deletedId') }}</x-slot>
            </x-status-delete>
        @endif
        @if(session('statusRestore'))
            <x-status-restore/>
        @endif
    </div>
    <x-create-section>
        <x-slot name="action">teamRegister</x-slot>
        <div class="flex flex-col gap-1">
            <label for="name" class="font-medium text-zinc-700">Name</label>
            <input type="text" name="name" id="name" placeholder="Enter name" value="{{ old('name') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('name') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="countryId" class="font-medium text-zinc-700">Country</label>
            <select name="countryId" id="countryId" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                <option disabled selected>Choose a country</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('countryId') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="managerId" class="font-medium text-zinc-700">Manager</label>
            <select name="managerId" id="managerId" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                <option disabled selected>Choose a manager</option>
                @foreach($managers as $manager)
                    <option value="{{ $manager->id }}">{{ $manager->name }} {{ $manager->surname }}</option>
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('managerId') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="leagueId" class="font-medium text-zinc-700">League</label>
            <select name="leagueId" id="leagueId" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                <option disabled selected>Choose a manager</option>
                @foreach($leagues as $league)
                    <option value="{{ $league->id }}">{{ $league->name }}</option>
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('leagueId') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="logoLink" class="font-medium text-zinc-700">Logo link</label>
            <input type="text" name="logoLink" id="logoLink" placeholder="Enter link" value="{{ old('logoLink') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('logoLink') }}</p>
        </div>
    </x-create-section>
</x-layout>