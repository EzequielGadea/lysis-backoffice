<x-layout>
    <x-slot name="title">Updating ad...</x-slot>
    <x-update-card>
        <x-slot name="backTo">adManagement</x-slot>
        <x-slot name="action">adUpdate</x-slot>
        <input type="hidden" name="id" value="{{ $ad->id }}">
        <div class="flex flex-col gap-1">
            <label for="link" class="font-medium text-zinc-700">Link (for redirection)</label>
            <input type="text" name="link" id="link" value="{{ $ad->link }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('link') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="path" class="font-medium text-zinc-700">Path (image resource)</label>
            <input type="text" name="path" id="path" value="{{ $ad->path }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('path') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="viewsHired" class="font-medium text-zinc-700">Views hired</label>
            <input type="number" min="1" name="viewsHired" id="viewsHired" value="{{ $ad->views_hired }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('viewsHired') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="currentViews" class="font-medium text-zinc-700">Current views</label>
            <input type="number" min="0" name="currentViews" id="currentViews" value="{{ $ad->current_views }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('currentViews') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="tagOneId" class="font-medium text-zinc-700">First tag</label>
            <select name="tagOneId" id="tagOneId" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                <option value="0" disabled>Choose first tag</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" 
                        @if($tag->id == $adTags[0]->tag_id)
                            selected
                        @endif
                        >{{ $tag->name }}
                    </option>
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('tagOneId') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="valueTagOne" class="font-medium text-zinc-700">First tag value</label>
            <input type="text" name="valueTagOne" id="valueTagOne" placeholder="Enter value for tag one" value="{{ $adTags[0]['value'] }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('valueTagOne') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="tagTwoId" class="font-medium text-zinc-700">Second tag</label>
            <select name="tagTwoId" id="tagTwoId" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                <option value="0" disabled>Choose first tag</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" 
                        @if($tag->id == $adTags[1]->tag_id)
                            selected
                        @endif
                        >{{ $tag->name }}
                    </option>
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('tagTwoId') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="valueTagTwo" class="font-medium text-zinc-700">Second tag value</label>
            <input type="text" name="valueTagTwo" id="valueTagTwo" placeholder="Enter value for tag one" value="{{ $adTags[1]['value'] }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('valueTagTwo') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="tagThree" class="font-medium text-zinc-700">Third tag</label>
            <select name="tagThreeId" id="tagThree" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                <option value="0" disabled>Choose first tag</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" 
                        @if($tag->id == $adTags[2]->tag_id)
                            selected
                        @endif
                        >{{ $tag->name }}
                    </option>
                @endforeach
            </select>
            <p class="text-sm text-red-600">{{ $errors->first('tagThreeId') }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <label for="valueTagThree" class="font-medium text-zinc-700">Third tag value</label>
            <input type="text" name="valueTagThree" id="valueTagThree" placeholder="Enter value for tag Three" value="{{ $adTags[2]['value'] }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            <p class="text-sm text-red-600">{{ $errors->first('valueTagThree') }}</p>
        </div>
        <p class="text-sm text-red-600">{{ $errors->first('id') }}</p>
    </x-update-card>
</x-layout>