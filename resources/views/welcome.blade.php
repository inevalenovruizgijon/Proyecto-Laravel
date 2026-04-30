<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbería El Estilo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans">
    <div class="h-screen flex flex-col justify-center items-center text-center px-4">
        <h1 class="text-6xl font-bold mb-4 text-yellow-500">BARBERÍA EL ESTILO</h1>
        <p class="text-xl mb-8 text-gray-300">Cortes clásicos y modernos para el hombre actual.</p>
        
        <div class="space-x-4">
            <a href="{{ route('citas.create') }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3 px-8 rounded-full text-lg transition duration-300 shadow-lg">
                PEDIR CITA
            </a>

            <a href="{{ route('login') }}" class="text-gray-400 hover:text-white underline text-sm">
                Acceso Barbero
            </a>
        </div>
    </div>
</body>
</html>