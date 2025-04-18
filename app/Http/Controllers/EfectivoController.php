<?php

namespace App\Http\Controllers;

use App\Models\venta;
use App\Models\carrito;
use App\Models\producto;
use App\Models\categoria;
use Illuminate\Http\Request;
use App\Models\detalle_carrito;
use App\Http\Controllers\Controller;

class EfectivoController extends Controller
{
    //
    public function mostrarPagoEfectivo(Request $request)
    {
        $user = auth()->user();
        $carrito = Carrito::where('cliente_id', $user->id)->first();
        $detalle_carrito = detalle_carrito::where('carrito_id', $carrito->id)->with('producto')->get();
        $metodopago = 'efectivo';
        return view('continuarefectivo', compact('detalle_carrito', 'carrito', 'metodopago'));
    }

    public function vistawelcome()
    {
        $productos = producto::inRandomOrder() // Esto obtendrá productos al azar
            ->orWhere('created_at', '>', now()->subDays(7)) // O puedes cambiar esto para obtener los productos más recientes en los últimos 7 días
            ->take(10) // Limita la cantidad de productos a 10
            ->get();

        $categoria = categoria::get();

        return view('welcome', compact('productos', 'categoria'));
    }

}
