<x-layout>
    <x-slot name="title">Player player...</x-slot>
    <x-update-card>
        <x-slot name="action">playerUpdate</x-slot>
        <x-slot name="backTo">playerManagement</x-slot>
        <input type="hidden" name="id" value="{{ $player->id }}">
        <div class="flex flex-col gap-1">
            <label for="name" class="font-medium text-zinc-700">Name</label>
            <input type="text" name="name" id="name" value="{{ $player->name }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('name') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="surname" class="font-medium text-zinc-700">Surname</label>
            <input type="text" name="surname" id="surname" value="{{ $player->surname }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('surname') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="birthDate" class="font-medium text-zinc-700">Birth date</label>
            <input type="date" name="birthDate" id="birthDate" value="{{ $player->birth_date }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('birthDate') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="weight" class="font-medium text-zinc-700">Weight(kg)</label>
            <input type="number" min="10" name="weight" id="weight" value="{{ $player->weight }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('weight') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="height" class="font-medium text-zinc-700">Height(cm)</label>
            <input type="number" min="10" name="height" id="height" value="{{ $player->height }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('height') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="country" class="font-medium text-zinc-700">Country</label>
            <select name="countryId" id="country" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                @foreach($countries as $country)
                    @if($player->country_id == $country->id)
                        <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                    @else
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endif
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('country') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="picture" class="font-medium text-zinc-700">Picture</label>
            <input type="file" name="picture" id="picture" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('picture') }}</p>
        </div>
    </x-update-card>
</x-layout>