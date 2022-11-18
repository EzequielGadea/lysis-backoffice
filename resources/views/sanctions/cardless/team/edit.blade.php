<x-layout>
    <x-slot name="title">Updating sanction</x-slot>
    <x-update-card>
        <x-slot name="action">sanctions/cardless/team/update/{{ $sanction->id }}</x-slot>
        <x-slot name="backTo">sanctions/cardless/team/index/{{ $sanction->eventPlayerTeam->event->id }}</x-slot>
        <div class="flex flex-col gap-1">
            <label class="font-medium text-zinc-700" for="minute">Minute</label>
            <input type="number" name="minute" min="0" value="{{ old('minute', $sanction->minute) }}"
                placeholder="Enter minute" class="w-64 bg-slate-200 px-3 py-1
                    rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('minute') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="sanction" class="font-medium text-zinc-700">Sanction</label>
            <select name="sanction" class="w-64 bg-slate-200 px-3 py-1 rounded-md shadow-inner" autocomplete="off">
                <option value="">-- Select sanction --</option>
                @foreach($sanctions as $sanctionInList)
                    <option value="{{ $sanctionInList->id }}" 
                            @if (old('sanction', $sanction->sanction->id) == $sanctionInList->id) selected @endif
                    >{{ $sanctionInList->description }}</option>
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('sanction') }}</p>
        </div>
        @if ($sanction->eventPlayerTeam->event->result()->result_type_id == '3')
            <div class="flex flex-col gap-1">
                <label class="font-medium text-zinc-700" for="set">Set</label>
                <select class="w-64 bg-slate-200 px-3 py-1 rounded-md shadow-inner" name="set" autocomplete="off">
                    <option value="">-- select set --</option>
                    @foreach ($sanction->eventPlayerTeam->event->result()->sets as $set)
                        <option value="{{ $set->id }}"
                            @if (old('set', $sanction->inSet->set_id) == $set->id) selected @endif>
                            {{ $set->number }}
                        </option>
                    @endforeach
                </select>
                <p class="text-sm text-red-600">{{ $errors->first('set') }}</p>
            </div>
        @endif
    </x-update-card>
</x-layout>
