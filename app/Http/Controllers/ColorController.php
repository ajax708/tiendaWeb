<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\color;
use Illuminate\Http\Request;
use App\Models\producto;

class ColorController extends Controller
{
    //
    public function index()
    {
        $colores = color::get();

        return view('VistaColor.index', compact('colores'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $color = new color();
        $color->nombre = $request->nombre;
        $color->save();

        activity()
            ->causedBy(auth()->user())
            ->log('Se creó un color: ' . $color->nombre);

        return redirect()->route('color.index');
    }

    public function show(Color $color)
    {
        //
    }

    public function edit(Color $color)
    {
        $c = color::find($color->id);
        return view('VistaColor.edit', compact('color'));
    }

    public function update(Request $request, color $color)
    {
        $c = color::where('id', $color->id)->first();
        $c->nombre = $request->nombre;
        $c->save();

        activity()
            ->causedBy(auth()->user())
            ->log('Se actualizó un color: ' . $c->nombre);

        return redirect()->route('color.index');
    }

    public function destroy($id)
    {
        $color = color::find($id);

        // Verificar si hay productos relacionados con el color
        if ($color->productos()->exists()) {
            return redirect()->route('color.index')->with('error', 'No se puede eliminar el color porque tiene productos asociados');
        }

        // Si no hay productos relacionados, se puede eliminar el color
        $color->delete();

        activity()
            ->causedBy(auth()->user())
            ->log('Se eliminó un color: ' . $color->nombre);

        return redirect()->route('color.index')->with('success', 'Color eliminado correctamente');
    }
}
