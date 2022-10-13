<x-layout>
    <x-slot name="title">Player management</x-slot>
    <x-nav/>
    <div class="flex flex-col items-center pt-6 px-8 w-full flex-grow">
        <p class="text-2xl text-zinc-800 font-semibold mb-6 w-full">Players</p>
        <div class="rounded-md overflow-x-auto shadow-xl w-full">
            <table class="table-auto border-collapse w-full">
                <thead>
                    <tr class="bg-slate-300">
                        <td class="pl-3 py-3 font-light text-zinc-800">ID</td>
                        <td class="py-3 font-light text-zinc-800">NAME</td>
                        <td class="py-3 font-light text-zinc-800">BIRTH DATE</td>
                        <td class="py-3 font-light text-zinc-800">HEIGHT & WEIGHT</td>
                        <td class="py-3 font-light text-zinc-800">COUNTRY</td>
                        <td class="py-3 font-light text-zinc-800">CREATED AT</td>
                        <td class="py-3 font-light text-zinc-800">UPDATED AT</td>
                        <td class="pr-3 py-3 font-light text-zinc-800 text-center">ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($players))
                        @foreach ($players as $player)
                            <tr class="border-b border-slate-300">
                                <td class="pl-3 text-zinc-800">{{ $player->id }}</td>
                                <td class="py-3 text-zinc-800">{{ $player->name }} {{ $player->surname }}</td>
                                <td class="py-3 text-zinc-800">{{ $player->birth_date }}</td>
                                <td class="py-3 text-zinc-800"><p><span class="font-semibold">Height(cm): </span>{{ $player->height }}</p>
                                <p><span class="font-semibold">Weight(kg): </span>{{ $player->weight }}</p></td>
                                <td class="py-3 text-zinc-800">{{ $player->country }}</td>
                                <td class="py-3 text-zinc-800">{{ $player->created_at }}</td>
                                <td class="py-3 text-zinc-800">{{ $player->updated_at }}</td>
                                <td class="pr-3 text-zinc-800">
                                    <div class="flex flex-col items-center">
                                        <form action="playerUpdate/{{ $player->id }}" method="GET">
                                            <button class="font-semibold text-blue-600">Edit</button>
                                        </form>
                                        <form action="playerDelete" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $player->id }}">
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
                <x-slot name="action">playerRestore</x-slot>
                <x-slot name="id">{{ session('deletedId') }}</x-slot>
            </x-status-delete>
        @endif
        @if(session('statusRestore'))
            <x-status-restore/>
        @endif
    </div>
    <x-create-section>
        <x-slot name="action">playerRegister</x-slot>
        <div class="flex flex-col gap-1">
            <label for="name" class="font-medium text-zinc-700">Name</label>
            <input type="text" name="name" id="name" placeholder="Enter name" value="{{ old('name') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('name') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="surname" class="font-medium text-zinc-700">Surname</label>
            <input type="text" name="surname" id="surname" placeholder="Enter surname" value="{{ old('surname') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('surname') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="birthDate" class="font-medium text-zinc-700">Birth date</label>
            <input type="date" name="birthDate" id="birthDate" placeholder="Enter birth date" value="{{ old('birthDate') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('birthDate') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="weight" class="font-medium text-zinc-700">Weight(kg)</label>
            <input type="number" min="10" name="weight" id="weight" placeholder="Enter weight" value="{{ old('weight') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('weight') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="height" class="font-medium text-zinc-700">Height(cm)</label>
            <input type="number" min="10" name="height" id="height" placeholder="Enter height" value="{{ old('height') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('height') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="country" class="font-medium text-zinc-700">Country</label>
            <select name="countryId" id="country" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                <option disabled selected>Select country</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('countryId') }}</p>
        </div>
    </x-create-section>
</x-layout>