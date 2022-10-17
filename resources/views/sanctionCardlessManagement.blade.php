<x-layout>
    <x-slot name="title">Sanction cardless management</x-slot>
    <x-nav/>
    <div class="flex flex-col items-center pt-6 px-8 w-full flex-grow">
        <p class="text-2xl text-zinc-800 font-semibold mb-6 w-full">Sanctions</p>
        <div class="rounded-md overflow-x-auto shadow-xl w-full">
            <table class="table-auto border-collapse w-full">
                <thead>
                    <tr class="bg-slate-300">
                        <td class="pl-3 py-3 font-light text-zinc-800">ID</td>
                        <td class="py-3 font-light text-zinc-800">DESCRIPTION</td>
                        <td class="py-3 font-light text-zinc-800">CREATED AT</td>
                        <td class="py-3 font-light text-zinc-800">UPDATED AT</td>
                        <td class="pr-3 py-3 font-light text-zinc-800 text-center">ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($sanctions))
                        @foreach ($sanctions as $sanction)
                            <tr class="border-b border-slate-300">
                                <td class="pl-3 text-zinc-800">{{ $sanction->id }}</td>
                                <td class="py-3 text-zinc-800">{{ $sanction->description }}</td>
                                <td class="py-3 text-zinc-800">{{ $sanction->created_at }}</td>
                                <td class="py-3 text-zinc-800">{{ $sanction->updated_at }}</td>
                                <td class="pr-3 text-zinc-800">
                                    <div class="flex flex-col items-center">
                                        <form action="sanctionCardlessUpdate/{{ $sanction->id }}" method="GET">
                                            <button class="font-semibold text-blue-600">Edit</button>
                                        </form>
                                        <form action="sanctionCardlessDelete" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $sanction->id }}">
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
                <x-slot name="action">sanctionCardlessRestore</x-slot>
                <x-slot name="id">{{ session('deletedId') }}</x-slot>
            </x-status-delete>
        @endif
        @if(session('statusRestore'))
            <x-status-restore/>
        @endif
    </div>
    <x-create-section>
        <x-slot name="action">sanctionCardlessRegister</x-slot>
        <div class="flex flex-col gap-1">
            <label for="description" class="font-medium text-zinc-700">Description</label>
            <input type="text" name="description" id="description" placeholder="Enter description" value="{{ old('description') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('description') }}</p>
        </div>
    </x-create-section>
</x-layout>