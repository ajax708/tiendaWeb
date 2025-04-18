@extends('dashboard')

@section('venta')
<div class="flex justify-center items-center mt-8">
    <div class="bg-white rounded-lg p-8 shadow-lg">
        <h2 class="text-3xl font-semibold mb-4">¡Pedido Exitoso!</h2>
        <p class="text-lg">Gracias por tu pedido. Ten en cuenta que tu pedido estara al pendiente del pago.</p>
        <div class="mt-8">
            <h3 class="text-xl font-semibold mb-2">Resumen de la Compra:</h3>
            <ul class="list-disc list-inside">
                @foreach ($detalle_carrito as $detalle)
                    <li class="text-base">
                        {{ $detalle->cantidad }} x {{ $detalle->producto->nombre }}:
                        BOB {{ number_format($detalle->producto->precio * $detalle->cantidad, 2) }}
                    </li>
                @endforeach

            </ul>
            <p class="text-xl mt-4">Total General: BOB {{ number_format($carrito->total, 2) }}</p>
        </div>
        <form action="{{ route('venta.store') }}" method="post" class="mt-8">
            @csrf
            <input type="text" name="carrito" hidden value="{{ $carrito->id }}">
            <button type="submit" class="bg-green-500 hover-bg-green-600 text-white font-bold py-3 px-6 rounded">Continuar</button>
        </form>
    </div>
</div>
@endsection