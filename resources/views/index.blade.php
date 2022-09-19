<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/output.css">
    <title>Backoffice | Home</title>
</head>
<body class="flex flex-row">
    <nav class="flex flex-col gap-5 pl-8 pr-3 pt-6 border-r-2 border-slate-500 h-screen w-48">
        <!-- FALTA AGREGAR ENLACES -->
        <a href="" class="font-medium text-zinc-800">Users</a>
        <a href="" class="font-medium text-zinc-800">Admins</a>
        <a href="" class="font-medium text-zinc-800">Ads</a>
    </nav>
    <div>
        <p>Users</p>
        <table>
            <thead>
                <tr>
                    <td>CLIENT ID</td>
                    <td>USER ID</td>
                    <td>NAME</td>
                    <td>COUNTRY</td>
                    <td>EMAIL</td>
                    <td>SUBSCRIPTION</td>
                    <td>ACTIONS</td>
                </tr>
            </thead>
            <!-- ACA VA FOR EACH DE PETICION A LA BD -->
        </table>
    </div> 
    <div class="bg-slate-50 flex flex-col gap-6 w-80 px-8 py-6">
        <p class="text-zinc-800 text-2xl font-semibold">Create</p>
         <form action="#" method="post" class="flex flex-col gap-3">
            <div class="flex flex-col gap-1">
                <label for="name" class="font-medium text-zinc-700">Name</label>
                <input type="text" id="name" placeholder="Enter name" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            </div>
            <div class="flex flex-col gap-1">
                <label for="surname" class="font-medium text-zinc-700">Surname</label>
                <input type="text" id="surname" placeholder="Enter surname" class="w-64 bg-slate-200 px-3 py-1 rounded-md placeholder:text-zinc-600 shadow-inner">
            </div>
            <div class="flex flex-col gap-1">
                
            </div>

         </form>
    </div>
</body>
</html>