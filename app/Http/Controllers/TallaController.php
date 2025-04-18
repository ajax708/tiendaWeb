<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\talla;
use Illuminate\Http\Request;

class TallaController extends Controller
{
    //
    public function index()
    {
        $tallas = talla::get();

        return view('VistaTalla.index', compact('tallas'));
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
        $talla = new Talla();
        $talla->tipo_talla_letra = $request->tipo_talla_letra;
        $talla->tipo_talla_numero = $request->tipo_talla_numero;
        $talla->save();
        
        activity()
            ->causedBy(auth()->user())
            ->log('Se creó una talla: ' . $talla->tipo_talla_letra . $talla->tipo_talla_numero);
        
        return redirect()->route('talla.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(talla $marca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Talla $talla)
    {
        $t = Talla::find($talla->id);
        return view('VistaTalla.edit', compact('t'));
    }

    /**
     * Update the specified resource in storage.
     *///
    public function update(Request $request, Talla $talla)
    {
        $t = Talla::where('id', $talla->id)->first();
        $t->tipo_talla_letra = $request->tipo_talla_letra;
        $t->tipo_talla_numero = $request->tipo_talla_numero;
        $t->save();

        activity()
            ->causedBy(auth()->user())
            ->log('Se actualizó una talla: ' . $t->tipo_talla_letra . $t->tipo_talla_numero);

        return redirect()->route('talla.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $talla = Talla::find($id);

        // Verificar si la talla no tiene productos asociados
        if ($talla->productos->isEmpty()) {
            $talla->delete();
            activity()
                ->causedBy(auth()->user())
                ->log('Se eliminó una talla: ' . $talla->tipo_talla_letra . $talla->tipo_talla_numero);
            return redirect()->route('talla.index')->with('success', 'Talla eliminada correctamente');
        }

        return redirect()->route('talla.index')->with('error', 'No se puede eliminar la talla porque tiene productos asociados');
    }

}
