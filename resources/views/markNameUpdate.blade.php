<x-layout>
    <x-slot name="title">Updating Mark name...</x-slot>
    <x-update-card>
        <x-slot name="action">markNameUpdate</x-slot>
        <x-slot name="backTo">markNameManagement</x-slot>
        <input type="hidden" name="id" value="{{ $markName->id }}">
        <div class="flex flex-col gap-1">
            <label for="name" class="font-medium text-zinc-700">Name</label>
            <input type="text" name="name" id="name" value="{{ $markName->name }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('name') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="criteriaId" class="font-medium text-zinc-700">Criteria</label>
            <select name="criteriaId" id="criteriaId" class="w-64 bg-slate-200 px-3 py-1 rounded-md shadow-inner" autocomplete="off">
                <option value="" selected disabled>Choose criteria</option>
                @foreach ($criterias as $criteria)
                    @if ($criteria->id == $markName->criteria->id) 
                        <option value="{{ $criteria->id }}" selected>{{ $criteria->name }}</option>
                    @else
                        <option value="{{ $criteria->id }}">{{ $criteria->name }}</option>
                    @endif
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('criteriaId') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="unitId" class="font-medium text-zinc-700">Unit</label>
            <select name="unitId" id="unitId" class="w-64 bg-slate-200 px-3 py-1 rounded-md shadow-inner" autocomplete="off">
                <option value="" disabled>Choose unit</option>
                @foreach ($units as $unit)
                    @if ($unit->id == $markName->unit->id)
                        <option value="{{ $unit->id }}" selected>{{ $unit->name }}</option>
                    @else
                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                    @endif
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('unitId') }}</p>
        </div>
    </x-update-card>
</x-layout>