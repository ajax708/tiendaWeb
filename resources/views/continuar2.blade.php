@extends('dashboard')

@section('venta')
<div class="flex justify-center items-center mt-8">
    <div class="bg-white rounded-lg p-8 shadow-lg">
        <h2 class="text-3xl font-semibold mb-4">¡Pago Exitoso!</h2>
        <p class="text-lg">Gracias por tu compra. Tu pedido se ha procesado exitosamente.</p>
        <div class="mt-8">
            <h3 class="text-xl font-semibold mb-2">Resumen de la Compra:</h3>
            <ul class="list-disc list-inside">
                    <li class="text-base">
                        1 x {{ $producto->nombre }}:
                        BOB {{ number_format($producto->precio_3d , 2) }}
                    </li>
            </ul>
            <p class="text-xl mt-4">Total General: BOB {{ number_format($producto->precio_3d, 2) }}</p>
        </div>
        <form action="{{ route('venta.store2') }}" method="post" class="mt-8">
            @csrf
            <input type="text" name="producto" hidden value="{{ $producto->id }}">
            <button type="submit" class="bg-green-500 hover-bg-green-600 text-white font-bold py-3 px-6 rounded">Continuar</button>
        </form>
    </div>
</div>
@endsection
