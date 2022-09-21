<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/output.css">
    <title>Admin Management</title>
</head>
<body class="flex flex-row justify-center">
    <nav class="flex flex-col pl-8 pr-3 pt-6 border-r-2 border-slate-500 h-screen w-48 justify-between">
        <!-- FALTA AGREGAR ENLACES -->
        <div class="flex flex-col gap-5">
            <a href="" class="font-medium text-zinc-800">Users</a>
            <a href="" class="font-medium text-zinc-800">Admins</a>
            <a href="" class="font-medium text-zinc-800">Ads</a>
        </div>
        <form action="logout" method="POST">
            @csrf
            <button type="submit">Log out</button>
        </form>
    </nav>
    <div class="pt-6 px-8 w-[50rem] flex-grow">
        <p class="text-2xl text-zinc-800 font-semibold mb-6">Users</p>
        <div class="rounded-md overflow-hidden">
            <table class="table-auto border-collapse w-full">
                <thead>
                    <tr class="bg-slate-300">
                    <td class="pl-3 py-3 font-light text-zinc-800 w-1/12">ADMIN ID</td>
                    <td class="py-3 font-light text-zinc-800 w-1/4">NAME</td>
                    <td class="py-3 font-light text-zinc-800">EMAIL</td>
                    <td class="pr-3 py-3 font-light text-zinc-800 text-center w-2/12">ACTIONS</td>
                </tr>
            </thead>
            <tbody>
                @if (isset($admins))
                    @foreach ($admins as $admin)
                    <tr class="border-b border-slate-300">
                        <td class="pl-3 text-zinc-800">{{ $admin->id }}</td>
                        <td class="py-3 text-zinc-800">
                            <p class="text-zinc-800">
                                {{ $admin->name }}
                            </p>
                        </td>
                        <td class="py-3 text-zinc-800">{{ $admin->email }}</td>
                        <td class="pr-3 text-zinc-800">
                            <div class="flex flex-col items-center">
                                <button class="font-semibold text-blue-600">Edit</button>
                                <form action="userDelete" method="POST">
                                    @csrf
                                    <input type="hidden" name="adminId" value="{{ $admin->id }}">
                                    <button class="font-semibold text-blue-600" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        @if (session('statusDelete'))
            {{ session('statusDelete') }}
        @endif
    </div>
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
            <p class="p-4 text-green-600 bg-green-100 rounded-md">{{ session('statusCreate') }}</p>
        @endif
    </div>
</body>
</html>