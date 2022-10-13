<x-layout>
    <x-slot name="title">Sanction card management</x-slot>
    <x-nav/>
    <div class="flex flex-col items-center pt-6 px-8 w-full flex-grow">
        <p class="text-2xl text-zinc-800 font-semibold mb-6 w-full">Sanction card</p>
        <div class="rounded-md overflow-x-auto shadow-xl w-full">
            <table class="table-auto border-collapse w-full">
                <thead>
                    <tr class="bg-slate-300">
                        <td class="pl-3 py-3 font-light text-zinc-800">CARD ID</td>
                        <td class="py-3 font-light text-zinc-800">NAME</td>
                        <td class="py-3 font-light text-zinc-800">CREATED AT</td>
                        <td class="py-3 font-light text-zinc-800">UPDATED AT</td>
                        <td class="pr-3 py-3 font-light text-zinc-800 text-center">ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($cards))
                        @foreach ($cards as $card)
                            <tr class="border-b border-slate-300">
                                <td class="pl-3 text-zinc-800">{{ $card->id }}</td>
                                <td class="py-3 text-zinc-800">{{ $card->color }}</td>
                                <td class="py-3 text-zinc-800">{{ $card->created_at }}</td>
                                <td class="py-3 text-zinc-800">{{ $card->updated_at }}</td>
                                <td class="pr-3 text-zinc-800">
                                    <div class="flex flex-col items-center">
                                        <form action="sanctionCardUpdate/{{ $card->id }}" method="GET">
                                            <button class="font-semibold text-blue-600">Edit</button>
                                        </form>
                                        <form action="sanctionCardDelete" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $card->id }}">
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
                <x-slot name="action">sanctionCardRestore</x-slot>
                <x-slot name="id">{{ session('deletedId') }}</x-slot>
            </x-status-delete>
        @endif
        @if(session('statusRestore'))
            <x-status-restore/>
        @endif
    </div>
    <x-create-section>
        <x-slot name="action">sanctionCardRegister</x-slot>
        <div class="flex flex-col gap-1">
            <label for="color" class="font-medium text-zinc-700">Color</label>
            <input type="text" name="color" id="color" placeholder="Enter color" value="{{ old('color') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('color') }}</p>
        </div>
    </x-create-section>
</x-layout>