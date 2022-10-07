<x-layout>
    <x-slot name="title">Updating subscription...</x-slot>
    <x-update-card>
        <x-slot name="action">subscriptionUpdate</x-slot>
        <x-slot name="backTo">subscriptionManagement</x-slot>
        <input type="hidden" name="id" value="{{ $subscription->id }}">
        <div class="flex flex-col gap-1">
            <label for="type" class="font-medium text-zinc-700">Type</label>
            <input type="text" name="type" id="type" value="{{ $subscription->type }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('type') }}</p>
            <label for="price" class="font-medium text-zinc-700">Price</label>
            <input type="number" name="price" id="price" value="{{ $subscription->price }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('price') }}</p>
            <label for="description" class="font-medium text-zinc-700">Description</label>
            <input type="text" name="description" id="description" value="{{ $subscription->description }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('description') }}</p>
        </div>
    </x-update-card>
</x-layout>