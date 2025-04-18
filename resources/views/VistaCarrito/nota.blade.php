@extends('dashboard')

@section('venta')
    @php
        use Carbon\Carbon;
    @endphp

    <div id="contenido-a-imprimir" class="container mx-auto mt-8">
        <div class="max-w-3xl mx-auto">
            <div class="flex justify-start my-4"></div>
            <div class="overflow-x-auto">
                <div class="container mx-auto p-4">
                    <div class="header flex justify-between items-center">
                        <div>
                            <img src="{{asset('img/logo.png')}}" alt="Logo" style="max-width: 150px;">
                        </div>
                        <div class="text-right">
                            <p class="text-gray-700 text-sm"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($ventas[0]->fecha)->format('d/m/Y') }}</p>
                            <p class="text-gray-700 text-sm"><strong>Número de Contacto:</strong> (+591) 70001234</p>
                            <p class="text-gray-700 text-sm"><strong>Dirección:</strong> Av. Libertad C/Angostura #23</p>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold mb-4">Nota de Venta</h2>
                    <div class="bg-white shadow-md rounded px-8 py-6 mb-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-700 text-sm"><strong>Refracgas</strong></p>
                                <p class="text-gray-700 text-sm"><strong>Cliente:</strong> {{ $ventas[0]->cliente }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-gray-700 text-sm"><strong>N° de Venta:</strong> #{{ $ventas[0]->venta_id }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="container mx-auto px-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-200">
                                <thead>
                                    <tr>
                                        <th class="bg-gray-100 text-left px-6 py-3">Item</th>
                                        <th class="bg-gray-100 text-left px-6 py-3">Cantidad</th>
                                        <th class="bg-gray-100 text-left px-6 py-3">Descripción</th>
                                        @if(!$es_3d->es_3d)
                                        <th class="bg-gray-100 text-left px-6 py-3">P. Unitario</th>
                                        @endif
                                        <th class="bg-gray-100 text-left px-6 py-3">P. Total</th>
                                        @if($es_3d->es_3d)
                                        <th class="bg-gray-100 text-left px-6 py-3">Descargar</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ventas as $venta)
                                        <tr>
                                            <td class="border-t px-6 py-4">{{ $loop->iteration }}</td>
                                            <td class="border-t px-6 py-4">{{ $venta->cantidad }}</td>
                                            <td class="border-t px-6 py-4">
                                                <p class="font-semibold text-left">{{ $venta->nombre }}</p>
                                                <p class="text-xs text-left">{{ $venta->descripcion }}</p>
                                                <!-- Agregar más detalles si es necesario -->
                                            </td>
                                            @if(!$es_3d->es_3d)
                                            <td class="border-t px-6 py-4">BOB {{ number_format($venta->punit, 2) }}</td>
                                            @endif
                                            <td class="border-t px-6 py-4">BOB {{ number_format($venta->precio, 2) }}</td>
                                            @if($es_3d->es_3d)
                                            <td class="border-t px-6 py-4">
                                                <a href="{{ asset( 'storage/' . $venta->td) }}" download="descarga.zip" class="btn btn-primary">
                                                    Descargar Modelo 
                                                </a>
                                            </td>
                                            @endif
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="border-t text-right pr-6 py-3 font-bold">Total General:</td>
                                        <td class="border-t px-6 py-3 font-bold">BOB {{ number_format($ventas[0]->total, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button onclick="imprimirContenido()"
                            class="bg-blue-500 hover-bg-blue-700 text-white font-bold py-2 px-4 rounded">Imprimir</button>
                        <button
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"><a href="{{ route('venta.index') }}">Volver</a></button>
                    </div>
                    <div class="notes mt-6">
                        <p class="text-sm">Notas:</p>
                        <p class="text-sm">1. Asegúrese de que la información en esta factura sea correcta.</p>
                        <p class="text-sm">2. No se aceptan devoluciones después de 30 días.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function imprimirContenido() {
            var contenido = document.getElementById("contenido-a-imprimir").innerHTML;
            var ventana = window.open("", "_blank");
            ventana.document.write('<html><head><title>Nota de Venta</title><style>body {font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f2f2f2;} .container {max-width: 800px; margin: 0 auto; padding: 20px; background-color: #fff; border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);} .header {text-align: center;} .header h2 {font-size: 24px; color: #333; margin: 0 0 10px;} .header p {font-size: 16px; color: #777;} .invoice {margin-top: 20px;} table {width: 100%; border-collapse: collapse;} th, td {border: 1px solid #ccc; padding: 10px; text-align: center;} th {background-color: #f9f9f9; color: #333;} .total {margin-top: 20px; text-align: right;} .total p {font-weight: bold; font-size: 18px; color: #333;} .print-button {text-align: center; margin-top: 20px;} .print-button button {background-color: #007bff; color: #fff; padding: 10px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer;} .notes {margin-top: 20px;} .notes p {font-size: 14px;}</style></head><body>' + contenido + '</body></html>');
            ventana.document.close();
            ventana.print();
            ventana.close();
        }
    </script>
@endsection