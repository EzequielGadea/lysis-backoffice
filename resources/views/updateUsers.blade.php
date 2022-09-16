<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/output.css">
    <title>Backoffice | Actualizar usuarios</title>
</head>
<body>
    <main class="flex flex-col item-center justify-center p-5 w-full">
        <div class="flex item-center justify-center">
            <form action="" class="w-96 flex flex-col gap-2 justify-center bg-gray-100 rounded-t-xl p-4 pb-4 shadow-xl shadow-gray-300 mt-10 border-b-black border-b-2 border-b-solid">
                <h1 class="w-full flex justify-center text-xl">Buscar usuario</h1>
                <div class="w-100 flex flex-col justify-center p-2 gap-3">
                    <input type="email" name="searchUserEmail" id="searchUserEmail" class="w-56 flex flex-col rounded-lg p-1 text-sm m-auto border-2 border-gray-300" placeholder="Buscar por email">
                </div>
                <button type="submit" class="w-auto flex justify-center bg-purple-600 text-white p-2 pl-2 pr-2 rounded-lg m-auto">
                    Buscar usuario
                </button>
            </form>
        </div>
        <div class="flex item-center justify-center">
            <form action="" class="w-96 flex flex-col gap-2 justify-center bg-gray-100 rounded-b-xl p-4 pb-4 shadow-xl shadow-gray-300">
                <h1 class="w-full flex justify-center text-xl">Actualizar datos</h1>
                <div class="w-100 flex flex-col justify-center p-2 gap-3">
                    <input type="text" name="updateUserName" id="updateUserName" class="w-56 flex flex-col rounded-lg p-1 text-sm m-auto border-2 border-gray-300" placeholder="Actualizar nombre">
                    <input type="text" name="updateUserSurname" id="updateUserSurname" class="w-56 flex flex-col rounded-lg p-1 text-sm m-auto border-2 border-gray-300" placeholder="Actualizar apellido">
                    <input type="date" name="updateUserBirthdate" id="updateUserBirthdate" class="w-56 flex flex-row rounded-lg p-1 text-sm m-auto border-2 border-gray-300">
                    <input type="text" name="updateUserCountry" id="updateUserCountry" class="w-56 flex flex-row rounded-lg p-1 text-sm m-auto border-2 border-gray-300" placeholder="Actualizar nacionalidad">
                    <input type="email" name="updateUserEmail" id="updateUserEmail" class="w-56 flex flex-col rounded-lg p-1 text-sm m-auto border-2 border-gray-300" placeholder="Actualizar email">
                    <input type="password" name="updateUserPassword" id="updateUserPassword" class="w-56 flex flex-col rounded-lg p-1 text-sm m-auto border-2 border-gray-300" placeholder="Actualizar contraseña">
                    <div class="flex flex-row justify-center p-1 gap-2 text-md">
                        <input type="checkbox" name="updateUserIfAdmin" id="updateUserIfAdmin"> Usuario administrador
                    </div>
                </div>
                <button type="submit" class="w-auto flex justify-center bg-purple-600 text-white p-2 pl-2 pr-2 rounded-lg m-auto">
                    Actualizar usuario
                </button>
            </form>
        </div>
    </main>
</body>