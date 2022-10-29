<div class="flex flex-col gap-3">
    <div class="flex flex-col gap-1">
        <label for="resultTypeId" class="font-medium text-zinc-700">Result type</label>
        <select wire:model="selectedResultTypeId" name="resultTypeId" id="resultTypeId" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
            <option value="" disabled>Choose result type</option>
            @foreach ($resultTypes as $type)
                @if ($type->id == $result->type->id)
                    <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                @else
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endif
            @endforeach
            <p class="text-sm text-red-600">{{ $errors->first('resultTypeId') }}</p>
        </select>
    </div>
    @if ($selectedResultTypeId == 1)
        <div class="flex flex-col gap-1">
            <label for="markNameId" class="font-medium text-zinc-700">Mark name</label>
            <select name="markNameId" id="markNameId"  class="w-64 bg-slate-200 px-3 py-1 rounded-md shadow-inner" autocomplete="off">
                <option selected disabled>Choose mark name</option>
                @foreach ($markNames as $markName)
                    @if ($markName->id == $result->markName->id)
                        <option value="{{ $markName->id }}" selected>{{ $markName->name }}</option>
                    @else
                        <option value="{{ $markName->id }}">{{ $markName->name }}</option>
                    @endif
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('markNameId') }}</p>
        </div>
    @endif
    @if ($selectedResultTypeId == 3)
        <div class="flex flex-col gap-1">
            <label for="setAmount" class="font-medium text-zinc-700">Amount of sets</label>
            <input type="number" min="1" name="setAmount" id="setAmount" placeholder="Enter amount of sets" value="{{ old('setAmount') }}"  class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('setAmount') }}</p>
        </div>
    @endif
</div>

