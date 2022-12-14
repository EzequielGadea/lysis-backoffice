<x-layout>
    <x-slot name="title">Ad management</x-slot>
    <x-nav/>
    <div class="flex flex-col items-center pt-6 px-8 w-[50rem] flex-grow">
        <p class="text-2xl text-zinc-800 font-semibold mb-6 w-full">Ads</p>
        <div class="rounded-md overflow-x-auto shadow-xl w-full">
            <table class="table-auto border-collapse w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-300">
                        <td class="p-3 font-light text-zinc-800">ID</td>
                        <td class="p-3 font-light text-zinc-800">LINK</td>
                        <td class="p-3 font-light text-zinc-800">IMAGE</td>
                        <td class="p-3 font-light text-zinc-800">LOCATION</td>
                        <td class="p-3 font-light text-zinc-800">VIEWS HIRED</td>
                        <td class="p-3 font-light text-zinc-800">CURRENT VIEWS</td>
                        <td class="p-3 font-light text-zinc-800">TAG:VALUE</td>
                        <td class="p-3 font-light text-zinc-800">CREATED AT</td>
                        <td class="p-3 font-light text-zinc-800">UPDATED AT</td>
                        <td class="p-3 font-light text-zinc-800 text-center">ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($ads))
                        @foreach ($ads as $ad)
                            <tr class="border-b border-slate-300">
                                <td class="p-3 text-zinc-800">{{ $ad->id }}</td>
                                <td class="p-3 text-zinc-800">{{ $ad->link }}</td>
                                <td class="p-3 text-zinc-800">{{ $ad->image }}</td>
                                <td class="p-3 text-zinc-800">{{ $ad->location }}</td>
                                <td class="p-3 text-zinc-800">{{ $ad->views_hired }}</td>
                                <td class="p-3 text-zinc-800">{{ $ad->current_views }}</td>
                                <td class="p-3 text-zinc-800">
                                    @foreach($tagsValues as $tagValue)
                                        @if($tagValue->id == $ad->id)
                                            <p><span class="font-semibold capitalize">{{ $tagValue->name }}:</span>
                                            {{ $tagValue->value }}</p>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="p-3 text-zinc-800">{{ $ad->created_at }}</td>
                                <td class="p-3 text-zinc-800">{{ $ad->updated_at }}</td>
                                <td class="p-3 text-zinc-800">
                                    <div class="flex flex-col items-center">
                                        <form action="adUpdate/{{ $ad->id }}" method="GET">
                                            <button class="font-semibold text-blue-600">Edit</button>
                                        </form>
                                        <form action="adDelete" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $ad->id }}">
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
                <x-slot name="action">adRestore</x-slot>
                <x-slot name="id">{{ session('deletedId') }}</x-slot>
            </x-status-delete>
        @endif
        @if(session('statusRestore'))
            <x-status-restore/>
        @endif
    </div>
    <x-create-section>
        <x-slot name="action">adRegister</x-slot>
        <div class="flex flex-col gap-1">
            <label for="link" class="font-medium text-zinc-700">Link</label>
            <input type="text" name="link" id="link" placeholder="Enter link" value="{{ old('link') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('link') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="image" class="font-medium text-zinc-700">Image</label>
            <input type="file" name="image" id="image" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('image') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="viewsHired" class="font-medium text-zinc-700">Views hired</label>
            <input type="number" name="viewsHired" id="viewsHired" placeholder="Enter views" value="{{ old('viewsHired') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('viewsHired') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="location" class="font-medium text-zinc-700">Location</label>
            <input type="text" name="location" id="location" placeholder="Enter location" value="{{ old('location') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('location') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="tagOne" class="font-medium text-zinc-700">First tag</label>
            <select name="tagOneId" id="tagOne" placeholder="Choose first tag" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                <option value="0" disabled selected>Choose first tag</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('tagOneId') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="valueTagOne" class="font-medium text-zinc-700">Value</label>
            <input type="text" name="valueTagOne" id="valueTagOne" placeholder="Enter value for tag one" value="{{ old('valueTagOne') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('valueTagOne') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="tagTwo" class="font-medium text-zinc-700">Second tag</label>
            <select name="tagTwoId" id="tagTwo" placeholder="Choose second tag" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                <option value="0" disabled selected>Choose second tag</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('tagTwoId') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="valueTagTwo" class="font-medium text-zinc-700">Value</label>
            <input type="text" name="valueTagTwo" id="valueTagTwo" placeholder="Enter value for tag two" value="{{ old('valueTagTwo') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('valueTagTwo') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="tagThree" class="font-medium text-zinc-700">Third tag</label>
            <select name="tagThreeId" id="tagThree" placeholder="Choose third tag" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                <option value="0" disabled selected>Choose third tag</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('tagThreeId') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="valueTagThree" class="font-medium text-zinc-700">Value</label>
            <input type="text" name="valueTagThree" id="valueTagThree" placeholder="Enter value for tag three" value="{{ old('valueTagThree') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('valueTagThree') }}</p>
        </div> 
    </x-create-section>
</div> 
</x-layout>