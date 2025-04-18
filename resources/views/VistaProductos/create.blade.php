@extends('dashboard')

@section('producto')
    @if ($categorias->isEmpty())
        <div class="w-full lg:w-1/2 mx-auto mb-8">
            <div class="bg-red-100 border border-red-600 rounded-md p-4">
                <p class="text-red-600 text-lg font-semibold mb-4">
                    <a href="{{ route('categoria.index') }}" class="text-black hover:underline">
                        Primero debe registrar una categoría
                    </a>
                </p>
            </div>
        </div>
    @else
        <div class="container mx-auto px-8 my-8 mt-8">
            <h2 class="text-3xl font-extrabold text-gray-800 mb-6">Registro de Producto</h2>
            <form action="{{ route('producto.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-2 px-8 py-4 gap-4">
                    <div id="gridColumns" class="col-span-2 lg:col-span-2">
                        {{-- Nombre y Descripción --}}
                        <div class="mb-6">
                            <label for="nombre" class="text-gray-600 font-semibold text-sm">Nombre del producto:</label>
                            <input type="text" name="nombre" id="nombre" required
                                class="border border-gray-400 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                        </div>
                        <div class="flex gap-4 grid grid-cols-2">

                            {{-- Categoria --}}
                            <div class="mb-6 col-span-1">
                                <label for="categoria" class="text-gray-600 font-semibold text-sm">Categoría:</label>
                                <select name="categoria" id="categoria" required
                                    class="border border-gray-400 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                                    <option selected disabled>Elige una categoría</option>
                                    @forelse ($categorias as $c)
                                        <option value="{{ $c->id }}">{{ $c->categoria }}</option>
                                    @empty
                                        <option disabled>Registra una nueva categoría</option>
                                    @endforelse
                                </select>
                            </div>
                            {{-- Material --}}
                            <div class="mb-6 col-span-1">
                                <label for="color" class="text-gray-600 font-semibold text-sm">Material:</label>
                                <select name="color" id="color"
                                    class="border border-gray-400 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                                    <option selected disabled>Elige un color</option>
                                    @forelse ($colores as $c)
                                        <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                                    @empty
                                        <option disabled>Registra un nuevo Material</option>
                                    @endforelse
                                </select>
                            </div>

                        </div>

                        {{-- Descripcion --}}
                        <div class="mb-6">
                            <label for="descripcion" class="text-gray-600 font-semibold text-sm">Descripción:</label>
                            <textarea name="descripcion" id="descripcion" required
                                class="border border-gray-400 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-green-500"></textarea>
                        </div>

                        <div class="flex gap-4 grid grid-cols-2">

                            {{-- Precio --}}
                            <div class="mb-6 col-span-1">
                                <label for="precio" class="text-gray-600 font-semibold text-sm">Precio: (BOB)</label>
                                <input type="number" name="precio" id="precio" required
                                    class="border border-gray-400 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                            </div>
                            {{-- Stock --}}
                            <div class="mb-6 col-span-1">
                                <label for="stock_min" class="text-gray-600 font-semibold text-sm">Stock Mínimo:</label>
                                <input type="number" name="stock_min" id="stock_min" required
                                    class="border border-gray-400 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                            </div>
                        </div>

                        <div class="flex gap-4 grid grid-cols-2">
                            {{-- Fotos --}}
                            <div class="mb-6 col-span-1">
                                <label for="fotos" class="text-gray-600 font-semibold text-sm">Fotos:</label>
                                <input type="file" name="fotos[]" id="fotos" multiple required
                                    class="block w-full text-sm text-slate-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-violet-50 file:text-violet-700
                                        hover:file:bg-violet-100">
                            </div>
                            {{-- Video --}}
                            <div class="mb-6 col-span-1">
                                <label for="video" class="text-gray-600 font-semibold text-sm">Video:</label>
                                <input type="file" name="video" id="video"
                                    class="block w-full text-sm text-slate-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-violet-50 file:text-violet-700
                                        hover:file:bg-violet-100">
                            </div>

                        </div>


                        <div class="mb-6 space-x-2">
                            <label for="es_3d" class="text-gray-600 font-semibold text-sm">Contiene modelo 3D:</label>
                            <input type="checkbox" name="es_3d" id="es_3d"
                                class="border border-gray-400 rounded-lg py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-green-500"
                                onclick="toggle3DFields()">
                        </div>

                    </div>


                    <div id="3dFields" style="display: none;" class="col-span-2 lg:col-span-1">

                        <div class="mb-6">
                            <label for="archivo_3d" class="text-gray-600 font-semibold text-sm">Archivo 3D:</label>
                            <input type="file" name="archivo_3d" id="archivo_3d"
                                class="block w-full text-sm text-slate-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-violet-50 file:text-violet-700
                                        hover:file:bg-violet-100">
                        </div>
                        <div class="mb-6">
                            <label for="zip_path" class="text-gray-600 font-semibold text-sm">Archivo ZIP:</label>
                            <input type="file" name="zip_path" id="zip_path"
                                class="block w-full text-sm text-slate-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-violet-50 file:text-violet-700
                                        hover:file:bg-violet-100">
                        </div>
                        <div class="mb-6">
                            <label for="descripcion_3d" class="text-gray-600 font-semibold text-sm">Descripción del
                                archivo
                                3D:</label>
                            <textarea name="descripcion_3d" id="descripcion_3d"
                                class="border border-gray-400 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-green-500"></textarea>
                        </div>

                        <div class="mb-6">
                            <label for="precio_3d" class="text-gray-600 font-semibold text-sm">Precio del modelo
                                3d: (BOB)</label>
                            <input type="number" name="precio_3d" id="precio_3d"
                                class="border border-gray-400 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                        </div>
                        <p><strong>contiene los formatos:</strong></p>
                        <div class="flex gap-4">
                            <div class="px-4 mb-6 space-x-2">
                                <label for="es_formato_obj" class="text-gray-600 font-semibold text-sm">.obj </label>
                                <input type="checkbox" name="es_formato_obj" id="es_formato_obj"
                                    class="border border-gray-400 rounded-lg py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-green-500"
                                    onclick="toggle3DFields()">
                            </div>
                            <div class="mb-6 space-x-2">
                                <label for="es_formato_gltf" class="text-gray-600 font-semibold text-sm">.gltf </label>
                                <input type="checkbox" name="es_formato_gltf" id="es_formato_gltf"
                                    class="border border-gray-400 rounded-lg py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-green-500"
                                    onclick="toggle3DFields()">
                            </div>
                            <div class="mb-6 space-x-2">
                                <label for="es_formato_fbx" class="text-gray-600 font-semibold text-sm">.fbx </label>
                                <input type="checkbox" name="es_formato_fbx" id="es_formato_fbx"
                                    class="border border-gray-400 rounded-lg py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-green-500"
                                    onclick="toggle3DFields()">
                            </div>
                            <div class="mb-6 space-x-2">
                                <label for="es_formato_stl" class="text-gray-600 font-semibold text-sm">.stl </label>
                                <input type="checkbox" name="es_formato_stl" id="es_formato_stl"
                                    class="border border-gray-400 rounded-lg py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-green-500"
                                    onclick="toggle3DFields()">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="mt-8 flex justify-end">
                    <button
                        class="bg-green-500 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-full focus:outline-none focus:shadow-outline">Guardar</button>
                    <a href="{{ route('producto.index') }}"
                        class="bg-red-500 hover:bg-red-700 text-white font-semibold py-2 px-6 ml-4 rounded-full">Cancelar</a>
                </div>
            </form>
        </div>
    @endif

    <script>
        function toggle3DFields() {
            var checkbox = document.getElementById('es_3d');
            var fields = document.getElementById('3dFields');
            fields.style.display = checkbox.checked ? 'block' : 'none';

            // fields.class = checkbox.checked ? 'col-span-2' : 'col-span-1';
            var fields2 = document.getElementById('gridColumns');
            if (checkbox.checked) {
                fields2.classList.remove('lg:col-span-2');
                fields2.classList.add('lg:col-span-1');
            } else {
                fields2.classList.remove('lg:col-span-1');
                fields2.classList.add('lg:col-span-2');
            }

        }
    </script>
@endsection
