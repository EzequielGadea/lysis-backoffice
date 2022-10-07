<x-layout>
    <x-slot name="title">Tag management</x-slot>
    <x-nav/>
    <div class="flex flex-col items-center pt-6 px-8 w-full flex-grow">
        <p class="text-2xl text-zinc-800 font-semibold mb-6 w-full">Tags</p>
        <div class="rounded-md overflow-x-auto shadow-xl w-full">
            <table class="table-auto border-collapse w-full">
                <thead>
                    <tr class="bg-slate-300">
                        <td class="pl-3 py-3 font-light text-zinc-800">TAG ID</td>
                        <td class="py-3 font-light text-zinc-800">NAME</td>
                        <td class="py-3 font-light text-zinc-800">CREATED AT</td>
                        <td class="py-3 font-light text-zinc-800">UPDATED AT</td>
                        <td class="pr-3 py-3 font-light text-zinc-800 text-center">ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($tags))
                        @foreach ($tags as $tag)
                            <tr class="border-b border-slate-300">
                                <td class="pl-3 text-zinc-800">{{ $tag->id }}</td>
                                <td class="py-3 text-zinc-800">{{ $tag->name }}</td>
                                <td class="py-3 text-zinc-800">{{ $tag->created_at }}</td>
                                <td class="py-3 text-zinc-800">{{ $tag->updated_at }}</td>
                                <td class="pr-3 text-zinc-800">
                                    <div class="flex flex-col items-center">
                                        <form action="tagUpdate/{{ $tag->id }}" method="GET">
                                            <button class="font-semibold text-blue-600">Edit</button>
                                        </form>
                                        <form action="tagDelete" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $tag->id }}">
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
        @if (session('statusDelete'))
            <p class="bg-red-100 text-red-600 p-4 rounded-md mt-12">{{ session('statusDelete') }}</p>
        @endif
    </div>
    <x-create-section>
        <x-slot name="action">tagRegister</x-slot>
        <div class="flex flex-col gap-1">
            <label for="name" class="font-medium text-zinc-700">Name</label>
            <input type="text" name="name" id="name" placeholder="Enter name" value="{{ old('name') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('name') }}</p>
        </div>
    </x-create-section>
</x-layout>