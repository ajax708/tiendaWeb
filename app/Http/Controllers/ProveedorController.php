<?php

namespace App\Http\Controllers;

use App\Models\categoria;
use App\Models\marca;
use App\Models\proveedor;
use Illuminate\Http\Request;
class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = proveedor::get();
        $arrayProveedores = [];
        foreach ($proveedores as $p) {
            $marca = categoria::where('id', $p->categoria_id)->first();

            $arrayProveedores[] = [
                "proveedor_id"    => $p->id,
                "producto_Nombre"    => $p->Nombre,
                "producto_Telefono"    => $p->Telefono,
                "marca"              => $marca->categoria,
            ];
        }
        

        return view('VistaProveedor.index', compact('arrayProveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $marcas = categoria::get();
        // dd($categorias->isEmpty());
        return view('VistaProveedor.create', compact('marcas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $p = new proveedor();
        $p->Nombre = $request->nombre;
        $p->Telefono = $request->telefono;
        $p->categoria_id = $request->marca;
        $p->save();

        activity()
    ->causedBy(auth()->user()) // El usuario responsable de la actividad
    ->log('Se creo un proveedor : ' . $p->Nombre);
        return redirect()->route('proveedor.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(proveedor $proveedor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        //
        $p = proveedor::find($id);
        $marcas = categoria::get();
        return view('VistaProveedor.edit', compact('p','marcas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $p = proveedor::where('id', $id)->first();
        $p->Nombre = $request->nombre;
        $p->Telefono = $request->telefono;
        $p->categoria_id = $request->marca;
        $p->save();
        activity()
    ->causedBy(auth()->user()) // El usuario responsable de la actividad
    ->log('Se actualizo un proveedor : ' . $p->Nombre);
        return redirect()->route('proveedor.index')->with('success', 'Proveedor Actualizado con Exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $prov = proveedor::find($id);
        $prov->delete();
        activity()
        ->causedBy(auth()->user()) // El usuario responsable de la actividad
        ->log('Se elimino un proveedor : ' . $prov->nombre);
        return redirect()->route('proveedor.index');
    }
}
