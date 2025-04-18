<?php

namespace App\Http\Controllers;

use App\Models\producto;
use App\Models\venta;
use App\Models\carrito;
use Illuminate\Http\Request;
use App\Models\detalle_carrito;

class StripeController extends Controller
{
    //


    public function checkout()
    {
        return view('checkout');
    }

    public function session(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $c = carrito::where('id', $request->carrito)->first();
        $cid = $c->id;
        $totalprice = (int)($c->total/7);
        $two0 = "00";
        $total = "$totalprice$two0";

        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'USD',
                        'product_data' => [
                            "name" => 'Compra de Cocina',
                        ],
                        'unit_amount'  => $total,
                    ],
                    'quantity'   => 1,
                ],

            ],
            'mode'        => 'payment',
            'success_url' => route('success'),
            'cancel_url'  => route('carrito.index'),
        ]);
        return redirect()->away($session->url);
    }


    public function registrarVentaTarjeta($clienteId, $total)
    {
        $venta = venta::get(); // ¿Estás seguro de que quieres usar $clienteId para la empresa_id?
        $venta->forma_pago = "tarjeta"; // Registra el método de pago como "tarjeta"
        return $venta; // Puedes retornar la venta si lo necesitas
    }

    public function session2(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $c = producto::where('id', $request->producto)->first();
        $cid = $c->id;
        $totalprice = (int)($c->precio_3d/7);
        $two0 = "00";
        $total = "$totalprice$two0";
        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'USD',
                        'product_data' => [
                            "name" => 'Compra de Modelo 3D',
                        ],
                        'unit_amount'  => $total,
                    ],
                    'quantity'   => 1,
                ],

            ],
            'mode'        => 'payment',
            'success_url' => route('success2', ['id' => $cid]),
            'cancel_url'  => route('carrito.index'),
        ]);
        return redirect()->away($session->url);
    }

    public function success2($cid)
    {
        // Lógica para manejar el éxito de la compra
        $producto = producto::find($cid);
        
        return view('continuar2', compact('producto'));
    }


    public function success()
    {
        $user = auth()->user();
        $carrito = Carrito::where('cliente_id', $user->id)->first();
        $detalle_carrito = detalle_carrito::where('carrito_id', $carrito->id)->with('producto')->get();
         // Registra la venta con método de pago "tarjeta"
        $this->registrarVentaTarjeta($user->id, $carrito->total);

        $metodopago = 'tarjeta';
        return view('continuar', compact('detalle_carrito', 'carrito', 'metodopago'));
    }
}
