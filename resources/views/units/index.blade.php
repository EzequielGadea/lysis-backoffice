<x-layout>
    <x-slot name="title">Event management</x-slot>
    <x-nav/>
    <div class="flex flex-col items-center pt-6 px-8 w-[50rem] flex-grow">
        <p class="text-2xl text-zinc-800 font-semibold mb-6 w-full">Units</p>
        <div class="rounded-md overflow-x-auto shadow-xl w-full">
            <table class="table-auto border-collapse whitespace-nowrap w-full">
                <thead>
                    <tr class="bg-slate-300">
                        <td class="p-3 font-light text-zinc-800">ID</td>
                        <td class="p-3 font-light text-zinc-800">NAME</td>
                        <td class="p-3 font-light text-zinc-800">UNIT</td>
                        <td class="p-3 font-light text-zinc-800">CREATED AT</td>
                        <td class="p-3 font-light text-zinc-800">UPDATED AT</td>
                        <td class="p-3 font-light text-zinc-800 text-center">ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($units))
                        @foreach ($units as $unit)
                            <tr class="border-b border-slate-300">
                                <td class="p-3 text-zinc-800 text-right">{{ $unit->id }}</td>
                                <td class="p-3 text-zinc-800">{{ $unit->name }}</td>
                                <td class="p-3 text-zinc-800">{{ $unit->unit }}</td>
                                <td class="p-3 text-zinc-800">{{ $unit->created_at }}</td>
                                <td class="p-3 text-zinc-800">{{ $unit->updated_at }}</td>
                                <td class="p-3 text-zinc-800">
                                    <div class="flex flex-col items-center">
                                        <form action="/unit/edit/{{ $unit->id }}" method="GET">
                                            <button class="font-semibold text-blue-600">Edit</button>
                                        </form>
                                        <form action="/unit/delete/{{ $unit->id }}" method="POST">
                                            @csrf
                                            @method('delete')
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
            <x-status-delete-get>
                <x-slot name="action">/unit/restore/{{ session('deletedId') }}</x-slot>
            </x-status-delete-get>
        @endif
        @if(session('statusRestore'))
            <x-status-restore/>
        @endif
    </div>
    <x-create-section>
        <x-slot name="action">unit/create</x-slot>
        <div class="flex flex-col gap-1">
            <label for="name" class="font-medium text-zinc-700">Name</label>
            <input type="text" placeholder="Enter unit name" name="name" id="name" value="{{ old('name') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('name') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="unit" class="font-medium text-zinc-700">unit</label>
            <input type="text" placeholder="Enter measurement units" name="unit" id="unit" value="{{ old('unit') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('unit') }}</p>
        </div>
    </x-create-section>
</x-layout>
