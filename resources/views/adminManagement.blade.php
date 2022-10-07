<x-layout>
    <x-slot name="title">Admin management</x-slot>
    <x-nav/>
    <div class="flex flex-col items-center pt-6 px-8 w-[50rem] flex-grow">
        <p class="text-2xl text-zinc-800 font-semibold mb-6 w-full">Admins</p>
        <div class="rounded-md overflow-hidden shadow-xl w-full">
            <table class="table-auto border-collapse w-full">
                <thead>
                    <tr class="bg-slate-300">
                    <td class="pl-3 py-3 font-light text-zinc-800">ADMIN ID</td>
                    <td class="py-3 font-light text-zinc-800 w-1/4">NAME</td>
                    <td class="py-3 font-light text-zinc-800">EMAIL</td>
                    <td class="py-3 font-light text-zinc-800">CREATED AT (UTC)</td>
                    <td class="py-3 font-light text-zinc-800">UPDATED AT (UTC)</td>
                    <td class="pr-3 py-3 font-light text-zinc-800 text-center w-2/12">ACTIONS</td>
                </tr>
                </thead>
                <tbody>
                    @if (isset($admins))
                        @foreach ($admins as $admin)
                            <tr class="border-b border-slate-300">
                                <td class="pl-3 text-zinc-800">{{ $admin->id }}</td>
                                <td class="py-3 text-zinc-800">{{ $admin->name }}</td>
                                <td class="py-3 text-zinc-800">
                                    <p>{{ $admin->email }}</p>
                                    <p class="text-sm text-zinc-600">Verified at (UTC): {{ $admin->email_verified_at }}</p>
                                </td>
                                <td class="py-3 text-zinc-800">{{ $admin->created_at }}</td>
                                <td class="py-3 text-zinc-800">{{ $admin->updated_at }}</td>
                                <td class="pr-3 text-zinc-800">
                                    <div class="flex flex-col items-center">
                                        <form action="adminUpdate/{{ $admin->id }}" method="GET">
                                            <button class="font-semibold text-blue-600">Edit</button>
                                        </form>
                                        <form action="adminDelete" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $admin->id }}">
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
                <x-slot name="action">adminRestore</x-slot>
                <x-slot name="id">{{ session('deletedId') }}</x-slot>
            </x-status-delete>
        @endif
        @if(session('statusRestore'))
            <x-status-restore/>
        @endif
    </div> 
    <div class="bg-slate-50 flex flex-col gap-6 w-80 px-8 py-6">
        <p class="text-zinc-800 text-2xl font-semibold">Create</p>
         <form action="/adminRegister" method="post" class="flex flex-col gap-3">
            @csrf
            <div class="flex flex-col gap-1">
                <label for="name" class="font-medium text-zinc-700">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter name" value="{{ old('name') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                <p class="text-sm text-red-600">{{ $errors->first('name') }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter email" value="{{ old('email') }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                <p class="text-sm text-red-600">{{ $errors->first('email') }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <label for="passowrd">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter password" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                <p class="text-sm text-red-600">{{ $errors->first('password') }}</p>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-3 py-1 w-fit rounded-md">Create admin</button>
         </form>
        @if (session('statusCreate'))
            <p class="p-4 text-green-600 bg-green-100 rounded-md"> {{ session('statusCreate') }}</p>
        @endif
    </div>
</x-layout>
