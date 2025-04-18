@extends('dashboard')

@section('venta')
<div class="container mx-auto px-4 mt-8">
    <h1 class="text-3xl font-bold mb-4">Compras Realizadas</h1>

    <!-- Tabla para Ventas Físicas -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold mb-4">Ventas Físicas</h2>
        <div class="w-full overflow-x-auto">
            <table class="w-full border-collapse border border-gray-200">
                <thead>
                    <tr>
                        <th class="bg-gray-100 text-left px-6 py-3">No. de Venta</th>
                        <th class="bg-gray-100 text-left px-6 py-3">Artículos</th>
                        <th class="bg-gray-100 text-left px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ventas_fisicas as $venta_fisica)
                    <tr>
                        <td class="border-t px-6 py-4">{{ $venta_fisica['venta']->id }}</td>
                        <td class="border-t px-6 py-4">
                            <ul class="list-disc ml-6">
                                @foreach ($venta_fisica['productos'] as $producto)
                                    <li>{{ $producto->producto_nombre }} ({{ $producto->producto_descripcion }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="border-t px-6 py-4">
                            <a href="{{ route('notaVenta', ['id' => $venta_fisica['venta']->id]) }}" class="text-blue-500 hover:underline mr-2">Ver Nota</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabla para Ventas 3D -->
    <div>
        <h2 class="text-2xl font-semibold mb-4">Ventas 3D</h2>
        <div class="w-full overflow-x-auto">
            <table class="w-full border-collapse border border-gray-200">
                <thead>
                    <tr>
                        <th class="bg-gray-100 text-left px-6 py-3">No. de Venta</th>
                        <th class="bg-gray-100 text-left px-6 py-3">Artículos</th>
                        <th class="bg-gray-100 text-left px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ventas_3d as $venta_3d)
                    <tr>
                        <td class="border-t px-6 py-4">{{ $venta_3d['venta']->id }}</td>
                        <td class="border-t px-6 py-4">
                            <ul class="list-disc ml-6">
                                @foreach ($venta_3d['productos'] as $producto)
                                    <li>{{ $producto->producto_nombre }} ({{ $producto->producto_descripcion }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="border-t px-6 py-4">
                            <a href="{{ route('notaVenta', ['id' => $venta_3d['venta']->id]) }}" class="text-blue-500 hover:underline mr-2">Ver Nota</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
