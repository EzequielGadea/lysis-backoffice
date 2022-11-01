<x-layout>
    <x-slot name="title">Mark name management</x-slot>
    <x-nav/>
    <div class="flex flex-col items-center pt-6 px-8 w-[50rem] flex-grow">
        <p class="text-2xl text-zinc-800 font-semibold mb-6 w-full">Marks Names</p>
        <div class="rounded-md overflow-x-auto shadow-xl w-full">
            <table class="table-auto border-collapse w-full">
                <thead>
                    <tr class="bg-slate-300">
                        <td class="pl-3 py-3 font-light text-zinc-800">ID</td>
                        <td class="py-3 font-light text-zinc-800">NAME</td>
                        <td class="py-3 font-light text-zinc-800">CRITERIA</td>
                        <td class="py-3 font-light text-zinc-800">CREATED AT</td>
                        <td class="py-3 font-light text-zinc-800">UPDATED AT</td>
                        <td class="pr-3 py-3 font-light text-zinc-800 text-center">ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($markNames))
                        @foreach ($markNames as $markName)
                            <tr class="border-b border-slate-300">
                                <td class="pl-3 text-zinc-800">{{ $markName->id }}</td>
                                <td class="py-3 text-zinc-800">{{ $markName->name }}</td>
                                <td class="py-3 text-zinc-800">{{ $markName->criteria->name }}</td>
                                <td class="py-3 text-zinc-800">{{ $markName->created_at }}</td>
                                <td class="py-3 text-zinc-800">{{ $markName->updated_at }}</td>
                                <td class="pr-3 text-zinc-800">
                                    <div class="flex flex-col items-center">
                                        <form action="markNameUpdate/{{ $markName->id }}" method="GET">
                                            <button class="font-semibold text-blue-600">Edit</button>
                                        </form>
                                        <form action="markNameDelete" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $markName->id }}">
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
                <x-slot name="action">markNameRestore</x-slot>
                <x-slot name="id">{{ session('deletedId') }}</x-slot>
            </x-status-delete>
        @endif
        @if(session('statusRestore'))
            <x-status-restore/>
        @endif
    </div>
    <x-create-section>
        <x-slot name="action">markNameRegister</x-slot>
        <div class="flex flex-col gap-1">
            <label for="name" class="font-medium text-zinc-700">Name</label>
            <input type="text" name="name" id="name" placeholder="Enter name" value="{{ old('name') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('name') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="criteriaId" class="font-medium text-zinc-700">Criteria</label>
            <select name="criteriaId" id="criteriaId" class="w-64 bg-slate-200 px-3 py-1 rounded-md shadow-inner" autocomplete="off">
                <option value="" selected disabled>Choose criteria</option>
                @foreach ($criterias as $criteria)
                    <option value="{{ $criteria->id }}">{{ $criteria->name }}</option>
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('criteriaId') }}</p>
        </div>
    </x-create-section>
</x-layout>