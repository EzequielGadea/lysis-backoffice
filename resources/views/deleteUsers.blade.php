<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/output.css">
    <title>Backoffice | Eliminar usuarios</title>
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
                <h1 class="w-full flex justify-center text-xl">Mostrar datos</h1>
                <div class="w-100 flex flex-col justify-center p-2 gap-3">
                    <div class="flex flex-row w-full">
                        <label class="flex justify-left mr-2">Nombre: </label>
                        <label for="userName" class="flex justify-right"></label>
                    </div>
                    <div class="flex flex-row w-full">
                        <label class="flex justify-left mr-2">Apellido: </label>
                        <label for="userName" class="flex justify-right"></label>
                    </div>
                    <div class="flex flex-row w-full">
                        <label class="flex justify-left mr-2">Nacimiento:</label>
                        <label for="userName" class="flex justify-right"></label>
                    </div>
                    <div class="flex flex-row w-full">
                        <label class="flex justify-left mr-2">Nacionalidad:</label>
                        <label for="userName" class="flex justify-right"></label>
                    </div>
                    <div class="flex flex-row w-full">
                        <label class="flex justify-left mr-2">Email:</label>
                        <label for="userName" class="flex justify-right"></label>
                    </div>
                    <div class="flex flex-row w-full">
                        <label class="flex justify-left mr-2">Contraseña:</label>
                        <label for="userName" class="flex justify-right"></label>
                    </div>
                    <div class="flex flex-row w-full">
                        <label class="flex justify-left mr-2">Administrador:</label>
                        <label for="userName" class="flex justify-right"></label>
                    </div>
                    
                    
                    
                    
                    
                </div>
                <button type="submit" class="w-auto flex justify-center bg-purple-600 text-white p-2 pl-2 pr-2 rounded-lg m-auto">
                    Actualizar usuario
                </button>
            </form>
        </div>
    </main>
</body>