<x-layout>
    <x-slot name="title">Updating event...</x-slot>
    <x-update-card>
        <x-slot name="action">eventUpdate</x-slot>
        <x-slot name="backTo">eventManagement</x-slot>
        <input type="hidden" name="eventId" value="{{ $event->id }}">
        <input type="hidden" name="isIndividual" value="{{ $event->isIndividual() }}">
        <div class="flex flex-col gap-1">
            <label for="startDate" class="font-medium text-zinc-700">Start date</label>
            <input type="datetime-local" name="startDate" id="startDate" value="{{ $event->start_date }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('startDate') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="leagueId" class="font-medium text-zinc-700">League</label>
            <select name="leagueId" id="leagueId" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                @foreach ($leagues as $league)
                    @if ($event->league->id == $league->id)
                        <option value="{{ $league->id }}" selected>{{ $league->name }}</option>
                    @else
                        <option value="{{ $league->id }}">{{ $league->name }}</option>
                    @endif
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('leagueId') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="venueId" class="font-medium text-zinc-700">Venue</label>
            <select name="venueId" id="venueId" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                <option disabled>Choose venue</option>
                @foreach ($venues as $venue)
                    @if ($event->venue->id == $venue->id)
                        <option value="{{ $venue->id }}" selected>{{ $venue->name }}</option>
                    @else
                        <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                    @endif
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('venueId') }}</p>
        </div>
        @if ($event->isIndividual())
            @livewire('event-update-individual', ['event' => $event])
        @else
            @livewire('event-update-teams', ['event' => $event])
        @endif
    </x-update-card>
</x-layout>