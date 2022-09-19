<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/output.css">
    <title>Backoffice | Insertar usuarios</title>
</head>
<body>
    <main class="flex flex-row item-center justify-center p-5 w-full">
        <div class="flex item-center justify-center">
            <form action="" class="w-96 flex flex-col gap-2 justify-center bg-gray-100 rounded-xl p-4 pb-4 shadow-xl shadow-gray-300 mt-10">
                <h1 class="w-full flex justify-center text-xl">Ingresar datos</h1>
                <div class="w-100 flex flex-col justify-center p-2 gap-3">
                    <input type="text" name="createUserName" id="createUserName" class="w-56 flex flex-col rounded-lg p-1 text-sm m-auto border-2 border-gray-300" placeholder="Ingresar nombre">
                    <input type="text" name="createUserSurname" id="createUserSurname" class="w-56 flex flex-col rounded-lg p-1 text-sm m-auto border-2 border-gray-300" placeholder="Ingresar apellido">
                    <input type="date" name="createUserBirthdate" id="createUserBirthdate" class="w-56 flex flex-row rounded-lg p-1 text-sm m-auto border-2 border-gray-300">
                    <input type="text" name="createUserCountry" id="createUserCountry" class="w-56 flex flex-row rounded-lg p-1 text-sm m-auto border-2 border-gray-300" placeholder="Ingresar nacionalidad">
                    <input type="email" name="createUserEmail" id="createUserEmail" class="w-56 flex flex-col rounded-lg p-1 text-sm m-auto border-2 border-gray-300" placeholder="Ingresar email">
                    <input type="password" name="createUserPassword" id="createUserPassword" class="w-56 flex flex-col rounded-lg p-1 text-sm m-auto border-2 border-gray-300" placeholder="Ingresar contraseña">
                    <div class="flex flex-row justify-center p-1 gap-2 text-md">
                        <input type="checkbox" name="createUserIfAdmin" id="createUserIfAdmin"> Usuario administrador
                    </div>
                </div>
                <button type="submit" class="w-auto flex justify-center bg-purple-600 text-white p-2 pl-2 pr-2 rounded-lg m-auto">
                    Ingresar usuario
                </button>
            </form>
        </div>
    </main>
</body>