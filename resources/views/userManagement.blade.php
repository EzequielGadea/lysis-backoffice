<x-layout>
    <x-slot name="title">Backoffice | Users</x-slot>
    <x-nav/>
    <div class="flex flex-col items-center pt-6 px-8 w-[50rem] flex-grow">
        <p class="text-2xl text-zinc-800 font-semibold mb-6 w-full">Users</p>
        <div class="rounded-md overflow-x-auto shadow-xl w-full">
            <table class="table-auto border-collapse w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-300">
                        <td class="pl-3 px-6 py-3 font-light text-zinc-800">USER ID</td>
                        <td class="py-3 px-6 font-light text-zinc-800">CLIENT ID</td>
                        <td class="py-3 px-6 font-light text-zinc-800">NAME</td>
                        <td class="py-3 px-6 font-light text-zinc-800">EMAIL</td>
                        <td class="py-3 px-6 font-light text-zinc-800">SUBSCRIPTION</td>
                        <td class="py-3 px-6 font-light text-zinc-800">CREATED AT (UTC)</td>
                        <td class="py-3 px-6 font-light text-zinc-800">UPDATED AT (UTC)</td>
                        <td class="pr-3 px-6 py-3 font-light text-zinc-800 text-center">ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($users))
                        @foreach ($users as $user)
                            <tr class="border-b border-slate-300">
                                <td class="pl-3 px-6 text-zinc-800">{{ $user->id }}</td>
                                <td class="py-3 px-6 text-zinc-800">{{ $user->client_id }}</td>
                                <td class="py-3 px-6 text-zinc-800">
                                    <p class="text-zinc-800">
                                        {{ $user->name }} {{ $user->surname }} 
                                    </p>
                                    <p class="text-sm text-zinc-600">
                                        Birthdate: {{ $user->birth_date }}
                                    </p>
                                </td>
                                <td class="py-3 px-6 text-zinc-800">
                                    <p>{{ $user->email }}</p>
                                    <p class="text-sm text-zinc-600">Verified at (UTC): {{ $user->email_verified_at }}</p>
                                </td>
                                <td class="py-3 px-6 text-zinc-800">{{ $user->type}}</td>
                                <td class="py-3 px-6 text-zinc-800">{{ $user->created_at }}</td>
                                <td class="py-3 px-6 text-zinc-800">{{ $user->updated_at }}</td>
                                <td class="pr-3 px-6 text-zinc-800">
                                    <div class="flex flex-col items-center">
                                        <form action="userUpdate/{{ $user->id }}" method="GET">
                                            <button class="font-semibold text-blue-600" type="submit">Edit</button>
                                        </form>
                                        <form action="userDelete" method="POST">
                                            @csrf
                                            <input type="hidden" name="userId" value="{{ $user->id }}">
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
                <x-slot name="action">userRestore</x-slot>
                <x-slot name="id">{{ session('deletedId') }}</x-slot>
            </x-status-delete>
        @endif
        @if(session('statusRestore'))
            <x-status-restore/>
        @endif
    </div> 
    <div class="bg-slate-50 flex flex-col gap-6 w-80 px-8 py-6">
        <p class="text-zinc-800 text-2xl font-semibold">Create</p>
         <form action="/userRegister" method="post" class="flex flex-col gap-3">
            @csrf
            <div class="flex flex-col gap-1">
                <label for="name" class="font-medium text-zinc-700">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter name" value="{{ old('name') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                <p class="text-sm text-red-600">{{ $errors->first('name') }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <label for="surname" class="font-medium text-zinc-700">Surname</label>
                <input type="text" name="surname" id="surname" placeholder="Enter surname" value="{{ old('surname') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                <p class="text-sm text-red-600">{{ $errors->first('surname') }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <label for="birthdate" class="font-medium text-zinc-700">Birthdate</label>
                <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                <p class="text-sm text-red-600">{{ $errors->first('birthdate') }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter email" value="{{ old('email') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                <p class="text-sm text-red-600">{{ $errors->first('email') }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <label for="subscription">Subscription</label>
                <select name="subscriptionId" id="subscription" placeholder="Choose subscription type" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                    @foreach($subscriptions as $subscription)
                        <option value="{{ $subscription->id }}">{{ $subscription->type }}</option>
                    @endforeach
                </select>
                <p class="text-sm text-red-600">{{ $errors->first('subscription') }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter password" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                <p class="text-sm text-red-600">{{ $errors->first('password') }}</p>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-3 py-1 w-fit rounded-md">Create user</button>
         </form>
        @if (session('statusCreate'))
            <p class="p-4 text-green-600 bg-green-100 rounded-md">{{ session('statusCreate') }}</p>
        @endif
    </div>
</x-layout>
