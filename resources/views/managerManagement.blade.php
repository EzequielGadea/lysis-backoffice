<x-layout>
    <x-slot name="title">Manager management</x-slot>
    <x-nav/>
    <div class="flex flex-col items-center pt-6 px-8 w-full flex-grow">
        <p class="text-2xl text-zinc-800 font-semibold mb-6 w-full">Managers</p>
        <div class="rounded-md overflow-x-auto shadow-xl w-full">
            <table class="table-auto border-collapse w-full">
                <thead>
                    <tr class="bg-slate-300">
                        <td class="pl-3 py-3 font-light text-zinc-800">MANAGER ID</td>
                        <td class="py-3 font-light text-zinc-800">NAME</td>
                        <td class="py-3 font-light text-zinc-800">BIRTH DATE</td>
                        <td class="py-3 font-light text-zinc-800">COUNTRY</td>
                        <td class="py-3 font-light text-zinc-800">CREATED AT</td>
                        <td class="py-3 font-light text-zinc-800">UPDATED AT</td>
                        <td class="pr-3 py-3 font-light text-zinc-800 text-center">ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($managers))
                        @foreach ($managers as $manager)
                            <tr class="border-b border-slate-300">
                                <td class="pl-3 text-zinc-800">{{ $manager->id }}</td>
                                <td class="py-3 text-zinc-800">{{ $manager->name }} {{ $manager->surname }}</td>
                                <td class="py-3 text-zinc-800">{{ $manager->birth_date }}</td>
                                <td class="py-3 text-zinc-800">{{ $manager->country }}</td>
                                <td class="py-3 text-zinc-800">{{ $manager->created_at }}</td>
                                <td class="py-3 text-zinc-800">{{ $manager->updated_at }}</td>
                                <td class="pr-3 text-zinc-800">
                                    <div class="flex flex-col items-center">
                                        <form action="managerUpdate/{{ $manager->id }}" method="GET">
                                            <button class="font-semibold text-blue-600">Edit</button>
                                        </form>
                                        <form action="managerDelete" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $manager->id }}">
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
                <x-slot name="action">managerRestore</x-slot>
                <x-slot name="id">{{ session('deletedId') }}</x-slot>
            </x-status-delete>
        @endif
        @if(session('statusRestore'))
            <x-status-restore/>
        @endif
    </div>
    <x-create-section>
        <x-slot name="action">managerRegister</x-slot>
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
            <label for="country" class="font-medium text-zinc-700">Country</label>
            <select name="countryId" id="country" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('country') }}</p>
        </div>
    </x-create-section>
</x-layout>