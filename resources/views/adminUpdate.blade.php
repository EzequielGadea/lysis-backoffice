<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/output.css')}}">
    <title>Updating admin...</title>
</head>
<body>
    @if(isset($admin))
        <form action="/adminUpdate" method="POST" class="flex flex-col items-start gap-5 p-0 pt-6 rounded-md bg-white overflow-hidden shadow-md w-fit m-auto mt-5">
            <p class="text-2xl font-semibold text-zinc-800 px-6 w-full">Edit</p>
            @csrf
            <input type="hidden" name="id" value="{{ $admin->id }}">
            <div class="flex flex-col items-start px-6 gap-2 flex-wrap">
                <div class="flex flex-col gap-1">
                    <label for="name" class="font-medium text-zinc-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ $admin->name }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                    <p class="text-sm text-red-600">{{ $errors->first('name') }}</p>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="email" class="font-medium text-zinc-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ $admin->email }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                    <p class="text-sm text-red-600">{{ $errors->first('email') }}</p>
                </div>
                <div class="flex flex-col">
                    <label for="password" class="font-medium text-zinc-700">Password</label>
                    <input type="password" name="password" id="password" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" placeholder="Leave empty to keep current">
                </div>
                <p class="text-sm text-red-600">{{ $errors->first('id') }}</p>
                @if (session('statusUpdate'))
                    <p class="p-4 text-green-600 bg-green-100 rounded-md">{{ session('statusUpdate') }}</p>
                @endif
            </div>
            <div class="flex flex-row justify-end items-center py-3 px-6 bg-slate-200 w-full gap-10">
                <a class="text-zinc-800 hover:cursor-pointer" id="cancel">Cancel</a>
                <button class="bg-blue-600 text-white px-3 py-1 w-fit rounded-md" type="submit">Save</button>
            </div>
        </form>
    @endif
    <form method="GET" action="/adminManagement" id="redirect">
        @csrf
    </form>
    @if(session('isRedirected') == 'true')
        <script>
            setTimeout(() => {
                document.getElementById('redirect').submit();
            }, 4000);
        </script>
    @endif
    <script>
        const cancel = document.getElementById('cancel');
        cancel.addEventListener('click', () => {
            document.getElementById('redirect').submit();
        });
    </script>
</body>
</html>