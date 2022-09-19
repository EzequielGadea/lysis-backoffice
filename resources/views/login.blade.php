<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/output.css">
    <title>Backoffice | Login</title>
</head>
<body class="font-sans antialiased">
    <main class="h-screen flex flex-col items-center justify-center">
        <div>
            <p class="text-5xl tracking-tighter text-zinc-800 font-bold mb-2">Welcome back</p>
            <p class="text-xl text-zinc-700 font-medium mb-5">Welcome back! Please enter your credentials.</p>
        </div>
        <form action="/index" method="post" class="flex flex-col">
            <label for="email" class="text-zinc-700 text-lg mb-1">Email</label>
            <input type="email" name="email" id="email" placeholder="Enter your email" class="w-96 shadow-inner py-2 px-3 border border-slate-500 rounded-md mb-5 placeholder:font-light">
            <label for="password" class="text-zinc-700 text-lg mb-1">Password</label>
            <input type="password" name="password" id="password" placeholder="Shh! It's super secret" class="w-96 shadow-inner py-2 px-3 border border-slate-500 rounded-md mb-5 placeholder:font-light">
            <input type="submit" value="Sign in" class="w-96 bg-slate-600 py-1 rounded-md text-white">
        </form>
    </main>
</body>
</html>