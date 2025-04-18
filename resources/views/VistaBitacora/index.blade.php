@extends('dashboard')

@section('usuario')
    <div class="flex flex-col items-center sm:flex-row">
        <div class="mt-4 sm:ml-4">
            <a href="{{ route('user.index') }}" class="bg-indigo-500 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition duration-300 ease-in-out">
                Usuarios
            </a>
        </div>
        <div class="mt-4 sm:ml-4">
            <a href="{{ route('rol.index') }}" class="bg-teal-500 hover:bg-teal-700 text-white px-4 py-2 rounded-md transition duration-300 ease-in-out">
                Roles
            </a>
        </div>
        <div class="mt-4 sm:ml-4">
            <a href="{{ route('permisos.index') }}" class="bg-orange-500 hover:bg-orange-700 text-white px-4 py-2 rounded-md transition duration-300 ease-in-out">
                Permisos
            </a>
        </div>
        <div class="mt-4 sm:ml-4">
            <a href="{{ route('bitacora.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-300 ease-in-out">
                Bitacora
            </a>
        </div>
    </div>
    <div class="my-8 mx-8">
        <div class="container mx-auto">
            <div class="overflow-x-auto mx-auto bg-white shadow-md rounded px-8 py-6 mt-8">
                <h2 class="text-3xl text-black font-semibold mb-6">Bitácora</h2>
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-1/2">
                        <label for="start_date" class="text-gray-600 font-semibold text-sm">Fecha de inicio:</label>
                        <input type="date" id="start_date" name="start_date" class="px-4 py-2 w-full border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                    </div>
                    <div class="w-1/2">
                        <label for="end_date" class="text-gray-600 font-semibold text-sm">Fecha de fin:</label>
                        <input type="date" id="end_date" name="end_date" class="px-4 py-2 w-full border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                    </div>
                    <button onclick="imprimirContenido()" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg">
                        Imprimir
                    </button>
                </div>
                <div id="activities_table">
                    @include('partials.activities_table')
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Obtén los inputs de fecha
        var startDateInput = $('#start_date');
        var endDateInput = $('#end_date');

        // Detecta los cambios en los inputs de fecha
        startDateInput.on('change', fetchFilteredActivities);
        endDateInput.on('change', fetchFilteredActivities);

        // Función para obtener los resultados filtrados mediante una solicitud AJAX
        function fetchFilteredActivities() {
            // Obtén los valores de fecha
            var startDate = startDateInput.val();
            var endDate = endDateInput.val();

            // Realiza la solicitud AJAX
            $.ajax({
                url: '{{ route('bitacora.index') }}',
                method: 'GET',
                data: {
                    start_date: startDate,
                    end_date: endDate
                },
                success: function(response) {
                    // Actualiza la tabla con los resultados filtrados
                    $('#activities_table').html(response.view);
                }
            });
        }
    });
</script>

<script>
    function imprimirContenido() {
        var contenido = document.getElementById("activities_table").innerHTML;
        var ventana = window.open("", "_blank");
        ventana.document.write('<html><head><title>Impresión</title><link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"><style>body {font-family: Arial, sans-serif;} .header {text-align: center; margin-bottom: 20px;} .header h1 {font-size: 24px; font-weight: bold; color: #3B82F6;} .header p {font-size: 16px; color: #6B7280;} table {border-collapse: separate; border-spacing: 0; width: 100%;} th, td {border: 1px solid #e5e7eb; padding: 12px; text-align: center; font-size: 14px;} th {background-color: #FCE7D4;} .bg-gray-100 {background-color: #F9FAFB;} .bg-blue-500 {background-color: #3B82F6; color: #fff;} .bg-blue-500:hover {background-color: #2563eb;}</style></head><body class="bg-gray-100"><div class="header"><h1>Refracgas</h1><p>Ubicación: Av. Libertad C/Angostura #23</p><p>Numero de Contacto: (+591) 70001234</p></div>' + contenido + '</body></html>');
        ventana.document.close();
        ventana.print();
        ventana.close();
    }
</script>

