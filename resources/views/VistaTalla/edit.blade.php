@extends('dashboard')

@section('producto')
<div class="w-full lg:w-1/2 mx-auto my-4">
    <h2 class="text-2xl font-bold text-black mt-8 mb-4 ml-4 uppercase">Actualizar Talla:</h2>
    <form action="{{ route('talla.update', $t->id) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="tipo_talla_letra">Letra:</label>
            <input type="text" name="tipo_talla_letra" id="tipo_talla_letra" required value="{{ $t->tipo_talla_letra }}" class="border border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="tipo_talla_numero">Número:</label>
            <input type="text" name="tipo_talla_numero" id="tipo_talla_numero" required value="{{ $t->tipo_talla_numero }}" class="border border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
        </div>

        <div class="flex items-center justify-between mb-4">
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">Actualizar</button>
            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"><a href="{{ route('talla.index') }}">Cancelar</a></button>
        </div>
    </form>
</div>
@endsection
