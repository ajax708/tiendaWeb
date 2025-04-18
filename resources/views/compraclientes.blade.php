@extends('dashboard')

@section('cliente')
    <div class="container mx-auto px-4 my-4">

        <div class="flex flex-col items-center sm:flex-row">
            <div class="mt-4 sm:ml-4">
                <h2 class="text-3xl font-semibold text-center dark:text-white mb-4">Historial de Compras de Clientes</h2>
            </div>
            <div class="mt-4 sm:ml-auto mr-4">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    id="imprimirBtn">Imprimir</button>
            </div>
        </div>

        <div class="my-8 mx-8">
            <div class="container mx-auto">
                <div class="overflow-x-auto mx-auto bg-white dark:bg-gray-800 rounded px-8 py-6">
                    <table class="min-w-full bg-white dark:bg-gray-800 border-gray-200 mt-4">
                        <thead class="bg-indigo-500 text-white">
                            <tr>
                                <th class="py-2 px-4">Cliente</th>
                                <th class="py-2 px-4">Fecha</th>
                                <th class="py-2 px-4">Producto</th>
                                <th class="py-2 px-4">Cantidad</th>
                                <th class="py-2 px-4">Precio Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 text-black dark:text-white">
                            @foreach ($compras as $compra)
                                @foreach ($compra['productos'] as $producto)
                                    <tr>
                                        <td class="py-2 text-center">{{ $compra['cliente'] }}</td>
                                        <td class="py-2 text-center">{{ $compra['fecha'] }}</td>
                                        <td class="py-2 text-center">{{ $producto->nombre }}</td>
                                        <td class="py-2 text-center">{{ $producto->cantidad }}</td>
                                        <td class="py-2 text-center">BOB {{ number_format($producto->precio_total, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function imprimirCompras() {
        var contenido = document.querySelector(".container-printable").innerHTML;
        var ventana = window.open("", "_blank");
        ventana.document.write(
            '<html><head><title>Impresión</title><link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"><style>body {font-family: Arial, sans-serif;} .header {text-align: center; margin-bottom: 20px;} .header h1 {font-size: 24px; font-weight: bold; color: #3B82F6;} .header p {font-size: 16px; color: #6B7280;} table {border-collapse: separate; border-spacing: 0; width: 100%;} th, td {border: 1px solid #e5e7eb; padding: 12px; text-align: center; font-size: 14px;} th {background-color: #FCE7D4;} .bg-gray-100 {background-color: #F9FAFB;} .bg-blue-500 {background-color: #3B82F6; color: #fff;} .bg-blue-500:hover {background-color: #2563eb;}</style></head><body class="bg-gray-100"><div class="header"><h1>REFRACGAS</h1><p>Ubicación: Av. Libertad C/Angostura #23</p><p>Numero de Contacto: (+591) 70001234</p></div>' +
            contenido + '</body></html>');
        ventana.document.close();
        ventana.print();
        ventana.close();
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('imprimirBtn').addEventListener('click', imprimirCompras);
    });
</script>
