<x-layout>
    <x-slot name="title">League management</x-slot>
    <x-nav/>
    <div class="flex flex-col items-center pt-6 px-8 w-full flex-grow">
        <p class="text-2xl text-zinc-800 font-semibold mb-6 w-full">Leagues</p>
        <div class="rounded-md overflow-x-auto shadow-xl w-full">
            <table class="table-auto border-collapse w-full">
                <thead>
                    <tr class="bg-slate-300">
                        <td class="pl-3 py-3 font-light text-zinc-800">ID</td>
                        <td class="py-3 font-light text-zinc-800">NAME</td>
                        <td class="py-3 font-light text-zinc-800">SPORT</td>
                        <td class="py-3 font-light text-zinc-800">COUNTRY</td>
                        <td class="py-3 font-light text-zinc-800">CREATED AT</td>
                        <td class="py-3 font-light text-zinc-800">UPDATED AT</td>
                        <td class="pr-3 py-3 font-light text-zinc-800 text-center">ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($leagues))
                        @foreach ($leagues as $league)
                            <tr class="border-b border-slate-300">
                                <td class="pl-3 text-zinc-800">{{ $league->id }}</td>
                                <td class="py-3 text-zinc-800">
                                    <div class="flex flex-row gap-4 items-center">
                                        <img src="images/{{ $league->picture }}" class="h-16 w-16 rounded-full shadow-md">
                                        <p>
                                            {{ $league->name }}
                                        </p>
                                    </div>
                                </td>
                                <td class="py-3 text-zinc-800">{{ $league->sport->name }}</td>
                                <td class="py-3 text-zinc-800">{{ $league->country->name }}</td>
                                <td class="py-3 text-zinc-800">{{ $league->created_at }}</td>
                                <td class="py-3 text-zinc-800">{{ $league->updated_at }}</td>
                                <td class="pr-3 text-zinc-800">
                                    <div class="flex flex-col items-center">
                                        <form action="leagueUpdate/{{ $league->id }}" method="GET">
                                            <button class="font-semibold text-blue-600">Edit</button>
                                        </form>
                                        <form action="leagueDelete" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $league->id }}">
                                            <button class="font-semibold text-blue-600" type="submit">Delete</button>
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
                <x-slot name="action">leagueRestore</x-slot>
                <x-slot name="id">{{ session('deletedId') }}</x-slot>
            </x-status-delete>
        @endif
        @if(session('statusRestore'))
            <x-status-restore/>
        @endif
    </div>
    <x-create-section>
        <x-slot name="action">leagueRegister</x-slot>
        <div class="flex flex-col gap-1">
            <label for="name" class="font-medium text-zinc-700">Name</label>
            <input type="text" name="name" id="name" placeholder="Enter name" value="{{ old('name') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('name') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="sport" class="font-medium text-zinc-700">Sport</label>
            <select name="sportId" id="sport" autocomplete="off" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                <option disabled selected>Select a sport</option>
                @foreach ($sports as $sport)
                    <option value="{{ $sport->id }}">{{ $sport->name }}</option>
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('sportId') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="country" class="font-medium text-zinc-700">Country</label>
            <select name="countryId" id="country" autocomplete="off" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                <option disabled selected>Select a country</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('countryId') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="picture" class="font-medium text-zinc-700">Picture</label>
            <input type="file" name="picture" id="picture" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('picture') }}</p>
        </div>
    </x-create-section>
</x-layout>