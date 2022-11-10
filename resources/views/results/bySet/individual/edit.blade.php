<x-layout>
    <x-slot name="title">Updating point</x-slot>
    <x-update-card>
        <x-slot name="action">
            set/individual/{{ $point->getTable() == 'player_visitor_set' ? 'visitor' : 'local' }}/update/{{ $point->id }}
        </x-slot>
        <x-slot name="backTo">set/individual/index/{{ $point->set->result->event->id }}</x-slot>

        <div class="flex flex-col gap-1">
            <label for="minute" class="font-medium text-zinc-700">
                Minute
            </label>
            <div>
                <input type="number" name="minute" placeholder="Enter minute" value="{{ old('minute', $point->minute) }}"
                    class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            </div>
            <p class="text-sm text-red-600">{{ $errors->first('minute') }}</p>
        </div>

        <div class="flex flex-col gap-1">
            <label for="points" class="font-medium text-zinc-700">
                Points
            </label>
            <div>
                @if ($point->points_in_favor == 0)
                    <input type="number" name="points" placeholder="Enter points"
                        value="{{ old('points', $point->points_against) }}"
                        class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                @else
                    <input type="number" name="points" placeholder="Enter points"
                        value="{{ old('points', $point->points_in_favor) }}"
                        class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                @endif
            </div>
            <p class="text-sm text-red-600">{{ $errors->first('points') }}</p>
        </div>

    </x-update-card>
</x-layout>
