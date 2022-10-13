<x-layout>
    <x-slot name="title">Updating sanction card...</x-slot>
    <x-update-card>
        <x-slot name="action">sanctionCardUpdate</x-slot>
        <x-slot name="backTo">sanctionCardManagement</x-slot>
        <input type="hidden" name="id" value="{{ $card->id }}">
        <div class="flex flex-col gap-1">
            <label for="color" class="font-medium text-zinc-700">Color</label>
            <input type="text" name="color" id="color" value="{{ $card->color }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('color') }}</p>
        </div>
    </x-update-card>
</x-layout>