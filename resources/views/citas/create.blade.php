<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programar Nueva Cita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    @php
        $hoy = date('Y-m-d\TH:i'); 
        $unAnioMas = date('Y-m-d\TH:i', strtotime('+1 year'));
    @endphp

    <nav class="bg-white border-b border-gray-200 py-4 mb-10 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Programar Nueva Cita - Barbería El Estilo
            </h2>
        </div>
    </nav>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500">
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('citas.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="cliente" class="block text-sm font-medium text-gray-700">Nombre del Cliente</label>
                        <input type="text" name="cliente" id="cliente" value="{{ old('cliente') }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border p-2" 
                               placeholder="Tu nombre completo" required>
                    </div>

                    <div class="mb-4">
                        <label for="user_id" class="block text-sm font-medium text-gray-700">Elige a tu Barbero</label>
                        <select name="user_id" id="user_id" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border p-2" required>
                            <option value="">-- ¿Quién quieres que te atienda? --</option>
                            @foreach($barberos as $barbero)
                                <option value="{{ $barbero->id }}" {{ old('user_id') == $barbero->id ? 'selected' : '' }}>
                                    {{ $barbero->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500 italic">Solo aparecen los barberos activos en el equipo.</p>
                    </div>

                    <div class="mb-4">
                        <label for="servicio_id" class="block text-sm font-medium text-gray-700">Servicio</label>
                        <select name="servicio_id" id="servicio_id" 
                                 class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border p-2" required>
                            <option value="">-- Selecciona un servicio --</option>
                            @foreach($servicios as $servicio)
                                <option value="{{ $servicio->id }}" {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}>
                                    {{ $servicio->nombre }} ({{ $servicio->precio }}€)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="fecha_cita" class="block text-sm font-medium text-gray-700">Fecha y Hora</label>
                        <input type="datetime-local" 
                               name="fecha_cita" 
                               id="fecha_cita" 
                               value="{{ old('fecha_cita') }}" 
                               min="{{ $hoy }}" 
                               max="{{ $unAnioMas }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border p-2" 
                               required>
                        <div class="mt-2 p-2 bg-yellow-50 text-yellow-800 text-xs rounded border border-yellow-200">
                            <strong>Horario comercial:</strong><br>
                            Mañanas: 09:30 - 13:30 | Tardes: 17:30 - 20:00
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ url('/') }}" class="text-sm text-gray-600 underline mr-4 hover:text-gray-900">Volver al inicio</a>
                        <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-all transform hover:scale-105">
                            Confirmar Cita
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>