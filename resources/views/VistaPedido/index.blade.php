@extends('dashboard')
@if (request()->isMethod('post'))
    <div class="alert alert-success">
        Pedidos realizados con exito.
    </div>
@endif
@section('compra')
    <div class="container mx-auto px-4 my-4">

        <div class="flex flex-col items-center sm:flex-row">
            <div class="mt-4 sm:ml-4">
                <a href="{{ route('pedido.index') }}"
                    class="bg-indigo-500 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition duration-300 ease-in-out">
                    Solicitar Pedidos
                </a>
            </div>
            <div class="mt-4 sm:ml-4">
                <a href="{{ route('compra.index') }}"
                    class="bg-teal-500 hover:bg-teal-700 text-white px-4 py-2 rounded-md transition duration-300 ease-in-out">
                    Notas de compras a proveedores
                </a>
            </div>
            <div class="mt-4 sm:ml-4">
                <a href="{{ route('proveedor.index') }}"
                    class="bg-orange-500 hover:bg-orange-700 text-white px-4 py-2 rounded-md transition duration-300 ease-in-out">
                    Proveedores
                </a>
            </div>
            <div class="mt-4 sm:ml-auto mr-4">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded-md transition duration-300 ease-in-out">Solicitar
                    Pedido</button>
            </div>
        </div>

        <div class="my-4 md:my-8 md:mx-8">
            <div class="container mx-auto">
                <form action="{{ route('pedido.store') }}" method="POST">
                    @csrf
                    <div class="overflow-x-auto mx-auto bg-white dark:bg-gray-800 rounded px-2 md:px-8 py-2 md:py-6">
                        <h2 class="text-2xl text-black dark:text-white font-bold mb-6">Solicitar Pedido</h2>
                        <table class="min-w-full bg-white dark:bg-gray-800 border-gray-200 mt-4">
                            <thead class="bg-indigo-500 text-white">
                                <tr>
                                    <th class="py-2 px-4">Producto</th>
                                    <th class="py-2 px-4">Descripción</th>
                                    <th class="py-2 px-4">Stock</th>
                                    <th class="py-2 px-4">Stock Mínimo</th>
                                    <th class="py-2 px-4">Actualizar Stock</th>
                                    <th class="py-2 px-4">Proveedor</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 text-black dark:text-white">
                                @foreach ($arrayProductos as $p)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ $p['producto_nombre'] }}</td>
                                        <td class="py-2 px-4 border-b">
                                            <p class="font-semibold">
                                                {{ $p['producto_descripcion'] }}
                                            </p>
                                            {{-- <p class="text-sm"> aqui va el proveedor</p> --}}
                                        </td>
                                        <td class="py-2 px-4 border-b">{{ $p['producto_stock'] }}</td>
                                        <td class="py-2 px-4 border-b">{{ $p['producto_stock_min'] }}</td>
                                        <td class="py-2 px-4 border-b">
                                            <input type="number" name="stock[]" class="w-20 px-2 py-1" value="0">
                                            <input type="number" name="id_producto[]" class="hidden"
                                                value="{{ $p['producto_id'] }}">
                                            <input type="text" name="nombre_proveedor[]" class="hidden"
                                                value="{{ $p['proveedor'] }}">
                                        </td>
                                        <td class="py-2 px-4 border-b">
                                            <label class="block text-gray-700 text-sm font-bold mb-2"
                                                for="proveedor"></label>
                                            <select name="proveedor[]" id="proveedor" required
                                                class="border border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-green-500">

                                                @foreach ($p['proveedor'] as $proveedor)
                                                    <option value="{{ $proveedor->id }}">{{ $proveedor->Nombre }}</option>
                                                @endforeach
                                            </select>
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
