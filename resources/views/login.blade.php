<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/output.css">
    <title>Backoffice | Login</title>
</head>
<body>
    <main>
        <div class="flex item-center justify-center">
            <form action="api/login" method="post" class="w-1/5 flex flex-col gap-2 justify-center bg-gray-100 rounded-xl p-4 pb-4 shadow-xl shadow-gray-300 mt-10">
                <h1 class="w-100 flex justify-center text-xl">Iniciar sesion</h1>
                <div class="w-100 flex flex-col justify-center p-2 gap-3">
                    <input type="email" name="emailAdmin" id="emailAdmin" class="w-46 flex flex-col rounded-lg p-1 text-sm m-auto border-2 border-gray-300" placeholder="Ingresar email">
                    <input type="password" name="passwordAdmin" id="passwordAdmin" class="w-46 flex flex-col rounded-lg p-1 text-sm m-auto border-2 border-gray-300" placeholder="Ingresar contraseña">
                </div>
                <button type="submit" class="w-auto flex justify-center bg-purple-600 text-white p-2 pl-2 pr-2 rounded-lg m-auto">
                    Iniciar sesion
                </button>
            </form>
        </div>
    </main>
</body>
</html>