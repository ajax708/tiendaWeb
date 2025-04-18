<?php

namespace App\Http\Controllers;

use App\Models\carrito;
use App\Models\detalle_carrito;
use App\Models\detalle_venta;
use App\Models\producto;
use App\Models\User;
use App\Models\venta;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $id = auth()->user()->id;
    $compras = venta::where('cliente_id', $id)->orderBy('id', 'desc')->get();

    // Inicializar arrays para ventas físicas y 3D
    $ventas_fisicas = [];
    $ventas_3d = [];

    // Obtener los detalles de productos para cada venta
    foreach ($compras as $compra) {
        $productosComprados = detalle_venta::where('venta_id', $compra->id)
            ->join('productos', 'productos.id', '=', 'detalle_ventas.producto_id')
            ->select('detalle_ventas.*', 'productos.nombre as producto_nombre', 'productos.descripcion as producto_descripcion')
            ->get();

        // Clasificar las ventas en físicas o 3D
        $venta = [
            'venta' => $compra,
            'productos' => $productosComprados,
        ];

        if ($compra->es_3d) {
            $ventas_3d[] = $venta;
        } else {
            $ventas_fisicas[] = $venta;
        }
    }

    return view('VistaCarrito.venta', compact('ventas_fisicas', 'ventas_3d'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $id = auth()->user()->id;
        $c = carrito::where('cliente_id', $id)->first();

        $venta = new venta();
        $venta->cliente_id = $id;
        $venta->empresa_id = $id;
        $venta->total = $c->total;
        $venta->forma_pago = "efectivo";
        $venta->save();
        // dd($c);
        

        $id_venta = venta::where('cliente_id', $id)->orderBy('id', 'desc')->first();
        $d = detalle_carrito::where('carrito_id', $c->id)->get();

        foreach ($d as $detalle) {
            $dv = new detalle_venta();
            $dv->venta_id = $id_venta->id;
            $dv->producto_id = $detalle->producto_id;
            $dv->cantidad = $detalle->cantidad;
            $dv->precio = $detalle->precio * $detalle->cantidad;
            $dv->save();

            $p = producto::where('id', $detalle->producto_id)->first();
            $p->stock = $p->stock - $detalle->cantidad;
            $p->save();

            $detalle->delete();
            $c->total = 0;
            $c->save();
            // return redirect()->route('venta.index')->with('success', 'Compra realizada con éxito');
        }
        activity()
            ->causedBy(auth()->user()) // El usuario responsable de la actividad
            ->log('Realizo una compra ' );
        return redirect()->route('venta.index')->with('success', 'Compra realizada con éxito');
    }



    public function store2(Request $request)
    {
        // dd($request);

        $id = auth()->user()->id;
        $c = producto::where('id', $request->producto)->first();
 
        $venta = new venta();
        $venta->cliente_id = $id;
        $venta->empresa_id = $id;
        $venta->total = $c->precio_3d;
        $venta->forma_pago = "tarjeta";
        $venta->es_3d = true;
        $venta->save();

        $id_venta = venta::where('cliente_id', $id)->orderBy('id', 'desc')->first();

            $dv = new detalle_venta();
            $dv->venta_id = $id_venta->id;
            $dv->producto_id = $c->id;
            $dv->cantidad = 1;
            $dv->precio = $c->precio_3d;
            $dv->save();


            // return redirect()->route('venta.index')->with('success', 'Compra realizada con éxito');
  
        activity()
            ->causedBy(auth()->user()) // El usuario responsable de la actividad
            ->log('Realizo una compra ' );
        return redirect()->route('venta.index')->with('success', 'Compra realizada con éxito');
    }


    public function storee(Request $request)
    {
        // dd($request);

        // dd($c);
        $id = auth()->user()->id;
        $c = carrito::where('cliente_id', $id)->first();
        $venta = new venta();
        $venta->cliente_id = $id;
        $venta->empresa_id = $id;
        $venta->total = $c->total;
        $venta->forma_pago = "efectivo";
        $venta->save();

        $id_venta = venta::where('cliente_id', $id)->orderBy('id', 'desc')->first();
        $d = detalle_carrito::where('carrito_id', $c->id)->get();

        foreach ($d as $detalle) {
            $dv = new detalle_venta();
            $dv->venta_id = $id_venta->id;
            $dv->producto_id = $detalle->producto_id;
            $dv->cantidad = $detalle->cantidad;
            $dv->precio = $detalle->precio * $detalle->cantidad;
            $dv->save();

            $p = producto::where('id', $detalle->producto_id)->first();
            $p->stock = $p->stock - $detalle->cantidad;
            $p->save();

            $detalle->delete();
            $c->total = 0;
            $c->save();
            // return redirect()->route('venta.index')->with('success', 'Compra realizada con éxito');
        }
        activity()
            ->causedBy(auth()->user()) // El usuario responsable de la actividad
            ->log('Realizo una compra de ' );

    }

    /**
     * Display the specified resource.
     */
    public function show(venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(venta $venta)
    {
        //
    }

    public function notaVenta(venta $id)
    {
        // dd($id);
        $ventas = Venta::where('ventas.id', $id->id)
            ->join('users as cl', 'cl.id', '=', 'ventas.cliente_id')
            ->join('detalle_ventas', 'detalle_ventas.venta_id', '=', 'ventas.id')
            ->join('productos', 'productos.id', '=', 'detalle_ventas.producto_id')
            ->join('users as em', 'em.id', '=', 'productos.id_propietario')
            ->select('ventas.id as venta_id', 'ventas.total', 'ventas.forma_pago', 'ventas.created_at as fecha',
            'cl.name as cliente', 'em.name as empresa'
            ,'productos.nombre', 'productos.descripcion', 'productos.imagen1', 'productos.precio as punit'
            ,'detalle_ventas.id as id_detalle','detalle_ventas.cantidad', 'detalle_ventas.precio','productos.zip_path as td'
            )
            ->get();
        $es_3d = Venta::where('ventas.id', $id->id)->first();
        
        return view('VistaCarrito.nota', compact('ventas', 'es_3d'));
    }

    public function mostrarCompras()
    {
        $compras = [];

        $comprasDB = Venta::all();

        foreach ($comprasDB as $compra) {
            $productosComprados = detalle_venta::where('venta_id', $compra->id)
                ->join('productos', 'productos.id', '=', 'detalle_ventas.producto_id')
                ->select('detalle_ventas.*', 'productos.nombre', 'productos.precio')
                ->get();

            $cliente = User::find($compra->cliente_id);
            $cliente_nombre = $cliente ? $cliente->name : 'Cliente no encontrado';

            $precioTotalCompra = 0;

            foreach ($productosComprados as $producto) {
                $producto->precio_total = $producto->precio * $producto->cantidad;
                $precioTotalCompra += $producto->precio_total;
            }
            
            $metodopago = ''; // Inicializa el tipo de pago

            if ($compra->forma_pago === 'efectivo') {
                $metodopago = 'Efectivo';
            } elseif ($compra->forma_pago === 'tarjeta') {
                $metodopago = 'Tarjeta';
            }

            $compras[] = [
                'cliente' => $cliente_nombre,
                'fecha' => $compra->created_at,
                'productos' => $productosComprados,
                'precioTotalCompra' => $precioTotalCompra, // Pasa el precio total de compra
                'tipoPago' => $metodopago,
            ];
        }

        return view('compraclientes', compact('compras'));
    }


    public function obtenerNombreCliente($cliente_id)
    {
        $cliente = User::find($cliente_id);
        return $cliente ? $cliente->nombre : 'Cliente no encontrado';
    }
}
