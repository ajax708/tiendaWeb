@extends('dashboard')

@section('usuario')
        <div class="w-full lg:w-1/2 mx-auto my-4">

            <h2 class="text-2xl font-bold text-black mt-8 mb-4 ml-4 uppercase">Actualizar Rol:</h2>
            <form action="{{ route('rol.update', $r->id) }}" method="POST" enctype="multipart/form-data"
                class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nombre">Rol:</label>
                    <input type="text" name="rol" id="rol" required value="{{$r->name}}"
                        class="border border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                </div>

                <div class="flex items-center justify-between mb-4">
                    <button
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">Actualizar</button>
                        <button
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"><a href="{{ route('rol.index') }}">Cancelar</a></button>
                </div>
            </form>
        </div>
@endsection
