<x-layout>
    <x-slot name="title">Country management</x-slot>
    <x-nav/>
    <div class="flex flex-col items-center pt-6 px-8 w-full flex-grow">
        <p class="text-2xl text-zinc-800 font-semibold mb-6 w-full">Countries</p>
        <div class="rounded-md overflow-x-auto shadow-xl w-full">
            <table class="table-auto border-collapse w-full">
                <thead>
                    <tr class="bg-slate-300">
                        <td class="pl-3 py-3 font-light text-zinc-800">ID</td>
                        <td class="py-3 font-light text-zinc-800">NAME</td>
                        <td class="py-3 font-light text-zinc-800">CREATED AT</td>
                        <td class="py-3 font-light text-zinc-800">UPDATED AT</td>
                        <td class="pr-3 py-3 font-light text-zinc-800 text-center">ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($countries))
                        @foreach ($countries as $country)
                            <tr class="border-b border-slate-300">
                                <td class="pl-3 text-zinc-800">{{ $country->id }}</td>
                                <td class="py-3 text-zinc-800">
                                    <div class="flex flex-row items-center gap-12">
                                        <div style="background-image: url({{ asset('images/' . $country->picture) }})" class="h-16 w-16 rounded-full shadow-md bg-center bg-contain bg-no-repeat"></div>
                                        <p>
                                            {{ $country->name }}
                                        </p>
                                    </div>
                                </td>
                                <td class="py-3 text-zinc-800">{{ $country->created_at }}</td>
                                <td class="py-3 text-zinc-800">{{ $country->updated_at }}</td>
                                <td class="pr-3 text-zinc-800">
                                    <div class="flex flex-col items-center">
                                        <form action="countryUpdate/{{ $country->id }}" method="GET">
                                            <button class="font-semibold text-blue-600">Edit</button>
                                        </form>
                                        <form action="countryDelete" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $country->id }}">
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
                <x-slot name="action">countryRestore</x-slot>
                <x-slot name="id">{{ session('deletedId') }}</x-slot>
            </x-status-delete>
        @endif
        @if(session('statusRestore'))
            <x-status-restore/>
        @endif
    </div>
    <x-create-section>
        <x-slot name="action">countryRegister</x-slot>
        <div class="flex flex-col gap-1">
            <label for="name" class="font-medium text-zinc-700">Name</label>
            <input type="text" name="name" id="name" placeholder="Enter name" value="{{ old('name') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('name') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="picture" class="font-medium text-zinc-700">Picture</label>
            <input type="file" name="picture" id="picture" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('picture') }}</p>
        </div>
    </x-create-section>
</x-layout>