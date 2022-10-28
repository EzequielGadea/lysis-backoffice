<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/output.css')}}">
    <title>Upadting user...</title>
</head>
<body>
    @if(isset($user))
        <form action="/userUpdate" method="POST" class="flex flex-col items-start gap-5 p-0 pt-6 rounded-md bg-white overflow-hidden shadow-md w-fit m-auto mt-5" enctype="multipart/form-data">
            <p class="text-2xl font-semibold text-zinc-800 px-6 w-full">Edit</p>
            @csrf
            <input type="hidden" name="id" value="{{ $user->id }}">
            <div class="flex flex-col items-start px-6 gap-2 flex-wrap">
                <div class="flex flex-col gap-1">
                    <label for="name" class="font-medium text-zinc-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ $user->name }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                    <p class="text-sm text-red-600">{{ $errors->first('name') }}</p>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="surname" class="font-medium text-zinc-700">Surname</label>
                    <input type="text" name="surname" id="surname" value="{{ $user->surname }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                    <p class="text-sm text-red-600">{{ $errors->first('surname') }}</p>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="birthdate" class="font-medium text-zinc-700">Birthdate</label>
                    <input type="date" name="birthdate" id="birthdate" value="{{ $user->birth_date }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                    <p class="text-sm text-red-600">{{ $errors->first('birthdate') }}</p>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="subscription" class="font-medium text-zinc-700">Subscription</label>
                    <select name="subscription" id="subscription" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" autocomplete="off">
                        @foreach($subscriptions as $subscription)
                            @if($user->type == $subscription->type)
                                <option value="{{ $subscription->id }}" selected>{{ $subscription->type }}</option>
                            @else
                                <option value="{{ $subscription->id }}">{{ $subscription->type }}</option>
                            @endif
                        @endforeach
                    </select>
                    <p class="text-sm text-red-600">{{ $errors->first('subscription') }}</p>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="email" class="font-medium text-zinc-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ $user->email }}" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                    <p class="text-sm text-red-600">{{ $errors->first('email') }}</p>
                </div>
                <div class="flex flex-col">
                    <label for="password" class="font-medium text-zinc-700">Password</label>
                    <input type="password" name="password" id="password" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner" placeholder="Leave empty to keep current">
                </div>
                <p class="text-sm text-red-600">{{ $errors->first('password') }}</p>
                <div class="flex flex-col">
                    <label for="profilePicture" class="font-medium text-zinc-700">Profile picture</label>
                    <input type="file" name="profilePicture" id="profilePicture" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
                </div>
                <p class="text-sm text-red-600">{{ $errors->first('profilePicture') }}</p>
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
    <form method="GET" action="/userManagement" id="redirect">
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