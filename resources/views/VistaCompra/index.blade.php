@extends('dashboard')

@section('compra')
    <div class="flex flex-col items-center sm:flex-row">
        <div class="mt-4 sm:ml-4">
            <a href="{{ route('pedido.index') }}" class="bg-indigo-500 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition duration-300 ease-in-out">
                Solicitar Pedidos
            </a>
        </div>
        <div class="mt-4 sm:ml-4">
            <a href="{{ route('compra.index') }}" class="bg-teal-500 hover:bg-teal-700 text-white px-4 py-2 rounded-md transition duration-300 ease-in-out">
                Notas de compras a proveedores
            </a>
        </div>
        <div class="mt-4 sm:ml-4">
            <a href="{{ route('proveedor.index') }}" class="bg-orange-500 hover:bg-orange-700 text-white px-4 py-2 rounded-md transition duration-300 ease-in-out">
                Proveedores
            </a>
        </div>
    </div>

    <div class="container mx-auto px-4 mt-8">
        <table class="min-w-full border border-gray-200 mt-4">
            <thead>
                <tr>
                    <th class="bg-gray-200 text-left px-6 py-3">No. de Compra</th>
                    <th class="bg-gray-200 text-left px-6 py-3">Ver Nota de Compra</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($c as $compra)
                <tr>
                    <td class="border-t px-6 py-4">{{ $compra->id }}</td>
                    <td class="border-t px-6 py-4">
                        <a href="{{ route('notaCompra', ['id' => $compra->id]) }}" class="text-blue-500 hover:underline">Ver Nota</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


@endsection
