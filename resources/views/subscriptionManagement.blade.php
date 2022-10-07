<x-layout>
    <x-slot name="title">Subscription management</x-slot>
    <x-nav/>
    <div class="flex flex-col items-center pt-6 px-8 w-full flex-grow">
        <p class="text-2xl text-zinc-800 font-semibold mb-6 w-full">Subscriptions</p>
        <div class="rounded-md overflow-x-auto shadow-xl w-full">
            <table class="table-auto border-collapse w-full">
                <thead>
                    <tr class="bg-slate-300">
                        <td class="pl-3 py-3 font-light text-zinc-800">SUBSCRIPTION ID</td>
                        <td class="py-3 font-light text-zinc-800">TYPE</td>
                        <td class="py-3 font-light text-zinc-800">PRICE</td>
                        <td class="py-3 font-light text-zinc-800">DESCRIPTION</td>
                        <td class="py-3 font-light text-zinc-800">CREATED AT</td>
                        <td class="py-3 font-light text-zinc-800">UPDATED AT</td>
                        <td class="pr-3 py-3 font-light text-zinc-800 text-center">ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($subscriptions))
                        @foreach ($subscriptions as $subscription)
                            <tr class="border-b border-slate-300">
                                <td class="pl-3 text-zinc-800">{{ $subscription->id }}</td>
                                <td class="py-3 text-zinc-800">{{ $subscription->type }}</td>
                                <td class="py-3 text-zinc-800">{{ $subscription->price }}</td>
                                <td class="py-3 text-zinc-800">{{ $subscription->description }}</td>
                                <td class="py-3 text-zinc-800">{{ $subscription->created_at }}</td>
                                <td class="py-3 text-zinc-800">{{ $subscription->updated_at }}</td>
                                <td class="pr-3 text-zinc-800">
                                    <div class="flex flex-col items-center">
                                        <form action="subscriptionUpdate/{{ $subscription->id }}" method="GET">
                                            <button class="font-semibold text-blue-600">Edit</button>
                                        </form>
                                        <form action="subscriptionDelete" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $subscription->id }}">
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
        <x-slot name="action">subscriptionRegister</x-slot>
        <div class="flex flex-col gap-1">
            <label for="type" class="font-medium text-zinc-700">Type</label>
            <input type="text" name="type" id="type" placeholder="Enter type" value="{{ old('type') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('type') }}</p>
            <label for="price" class="font-medium text-zinc-700">Price</label>
            <input type="number" name="price" id="price" placeholder="Enter price" value="{{ old('price') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('price') }}</p>
            <label for="description" class="font-medium text-zinc-700">Description</label>
            <input type="text" name="description" id="description" placeholder="Enter description" value="{{ old('description') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('description') }}</p>
        </div>
    </x-create-section>
</x-layout>