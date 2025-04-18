@extends('dashboard')

@section('venta')
<div class="container mx-auto mt-8">
    <div class="bg-white shadow-md rounded-lg p-6 lg:p-12">
        <h2 class="text-3xl text-black font-bold mb-6">Carrito de Compras</h2>

        @if (count($detalle_carrito) > 0)
        <div class="w-full sm:w-3/4">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Precio Unitario</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Precio Total</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalle_carrito as $producto)
                    <tr class="bg-white">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-16 w-16">
                                    <img class="h-16 w-16 rounded-lg object-cover"
                                        src="{{ asset('storage/' . $producto->imagen1) }}"
                                        alt="{{ $producto->nombre }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $producto->nombre }}</div>
                                    <div class="text-xs text-gray-500">{{ $producto->descripcion }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">{{ $producto->cantidad }}</td>
                        <td class="px-6 py-4 text-center">BOB {{ $producto->precio }}</td>
                        <td class="px-6 py-4 text-center">BOB {{ $producto->cantidad * $producto->precio }}</td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('carrito.destroy', $producto->id) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit"
                                    class="text-red-600 hover:text-red-800 cursor-pointer">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-between items-center mt-8">
                <form action="{{ route('session') }}" method="post">
                    @csrf
                    <input type="text" name="carrito" hidden value="{{ $carrito->id }}">
                    @foreach ($detalle_carrito as $producto)
                        <input type="text" name="producto{{ $producto->id }}" hidden value="{{ $producto->producto_id }}">
                    @endforeach
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-full transition duration-300" id="pagarTarjeta">Pagar con tarjeta</button>
                    
                </form>
                <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-full transition duration-300" id="pagarEfectivo">Pagar con efectivo</button>
                <script>
                    // Detectar clic en el botón "Pagar con tarjeta"
                    document.getElementById('pagarTarjeta').addEventListener('click', function () {
                        // No es necesario realizar ninguna acción aquí, el formulario se enviará a la ruta de Stripe
                    });
                
                    // Detectar clic en el botón "Pagar con efectivo"
                    document.getElementById('pagarEfectivo').addEventListener('click', function () {
                        // Redirigir al usuario a la página de efectivo
                        window.location.href = "{{ route('continuarefectivo') }}"; // Reemplaza 'pagina.efectivo' con la ruta correcta
                    });
                </script>
            <div class="text-2xl font-semibold">Total: BOB {{ $carrito->total }}</div>
        </div>
        @else
        <p>No hay productos en el carrito.</p>
        @endif
    </div>
    <div class="border-t my-4">
        <h2 class="text-2xl font-semibold text-black mt-8 mb-4 ml-4 uppercase">Encuentra mas Productos: </h2>
    </div>
    <x-welcome />
</div>
@endsection
