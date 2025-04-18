<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\categoria;
use App\Models\color;
use App\Models\producto;
use App\Models\User;
use App\Models\marca;
use App\Models\stock;
use App\Models\Talla; 
use Illuminate\Http\Request;
use ZipArchive;
use Illuminate\Support\Str;
class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = producto::get();
        $id = auth()->user()->id;
        $e = User::find($id);
        $p = producto::where('id_propietario', $e->id)->get();
        $categorias = categoria::get();
        foreach ($productos as $producto) {
            $producto->descripcion_limitada = Str::limit($producto->descripcion, 15);
        }

        return view('VistaProductos.index', compact('productos', 'e', 'p', 'categorias'));
        
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = categoria::get();
        $marcas = marca::get();
        
        $colores = color::all();
        // dd($categorias->isEmpty());
        return view('VistaProductos.create', compact('categorias','marcas','colores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
 

    $id = auth()->user()->id;
    $p = new Producto();
    $p->nombre = $request->nombre;
    $p->descripcion = $request->descripcion;
    $p->precio = $request->precio;
    $p->id_propietario = $id;
    $p->categoria_id = $request->categoria;
    $p->color_id = $request->color;
    $p->es_3d = $request->has('es_3d');
    $p->es_formato_obj = $request->has('es_formato_obj');
    $p->es_formato_gltf = $request->has('es_formato_gltf');
    $p->es_formato_fbx = $request->has('es_formato_fbx');
    $p->es_formato_stl = $request->has('es_formato_stl');
    $p->stock = 0;
    $p->stock_min = $request->stock_min;
    $p->descripcion_3d = $request->descripcion_3d;
    $p->precio_3d = $request->precio_3d;

    // Manejar carga de archivos 3D
    if ($request->hasFile('archivo_3d')) {
        $archivo = $request->file('archivo_3d');
        $archivoNombre = time() . '-' . $archivo->getClientOriginalName();
        $path = $archivo->storeAs('public/models', $archivoNombre);
        $p->archivo_3d = 'models/' . $archivoNombre;
    }

    // Manejar carga de archivo ZIP
    if ($request->hasFile('zip_path')) {
        $zip = $request->file('zip_path');
        $zipNombre = time() . '-' . $zip->getClientOriginalName();
        $path = $zip->storeAs('public/zip', $zipNombre);
        $p->zip_path = 'zip/' . $zipNombre;
    }

    // Manejar carga de imágenes
    if ($request->hasFile('fotos')) {
        $destino = 'public/img/fotosProductos/';
        $files = $request->file('fotos');
        foreach ($files as $key => $file) {
            $fotoNombre = time() . '-' . $file->getClientOriginalName();
            $path = $file->storeAs($destino, $fotoNombre);
            $p->{'imagen'.($key+1)} = 'img/fotosProductos/' . $fotoNombre;
        }
    }


        

    // Manejar carga de video
    if ($request->hasFile('video')) {
        $video = $request->file('video');
        $videoNombre = time() . '-' . $video->getClientOriginalName();
        $path = $video->storeAs('public/videos', $videoNombre);
        $p->video = 'videos/' . $videoNombre;
    }

    $p->save();

    activity()
        ->causedBy(auth()->user())
        ->log('Se creo un producto: ' . $p->nombre);

    return redirect()->route('producto.index')->with('success', 'Producto creado exitosamente.');
}

    
    

    /**
     * Display the specified resource.
     */
    public function show(producto $producto)
    {
        // dd($producto);
        $p = producto::find($producto->id);
        $u = User::find($p->id_propietario)->first();

        // dd($p);
        return view('VistaEmpresa.productoShow', compact('p', 'u'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        $p = $producto; 
        $categorias = Categoria::get();
        $marcas = Marca::get();
        $color = Color::all();
        return view('VistaProductos.edit', compact('p', 'categorias', 'marcas', 'color'));
    }

    public function update(Request $request, Producto $producto)
    {
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->categoria_id = $request->categoria;
        $producto->color_id = $request->color;
        $producto->stock_min = $request->stock_min;
        $producto->es_3d = $request->has('es_3d');
        $producto->es_formato_obj = $request->has('es_formato_obj');
        $producto->es_formato_gltf = $request->has('es_formato_gltf');
        $producto->es_formato_fbx = $request->has('es_formato_fbx');
        $producto->es_formato_stl = $request->has('es_formato_stl');
        $producto->descripcion_3d = $request->descripcion_3d;
        $producto->precio_3d = $request->precio_3d;

        // Manejar carga de archivos 3D
        if ($request->hasFile('archivo_3d')) {
            $archivo = $request->file('archivo_3d');
            $archivoNombre = time() . '-' . $archivo->getClientOriginalName();
            $path = $archivo->storeAs('public/models', $archivoNombre);
            $producto->archivo_3d = 'models/' . $archivoNombre;
        }

        // Manejar carga de archivo ZIP
        if ($request->hasFile('zip_path')) {
            $zip = $request->file('zip_path');
            $zipNombre = time() . '-' . $zip->getClientOriginalName();
            $path = $zip->storeAs('public/zip', $zipNombre);
            $producto->zip_path = 'zip/' . $zipNombre;
        }

        // Manejar carga de imágenes
        if ($request->hasFile('fotos')) {
            $destino = 'public/img/fotosProductos/';
            $files = $request->file('fotos');
            foreach ($files as $key => $file) {
                $fotoNombre = time() . '-' . $file->getClientOriginalName();
                $path = $file->storeAs($destino, $fotoNombre);
                $producto->{'imagen'.($key+1)} = 'img/fotosProductos/' . $fotoNombre;
            }
        }

        // Manejar carga de video
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoNombre = time() . '-' . $video->getClientOriginalName();
            $path = $video->storeAs('public/videos', $videoNombre);
            $producto->video = 'videos/' . $videoNombre;
        }

        $producto->save();

        activity()
            ->causedBy(auth()->user())
            ->log('Se actualizó el producto: ' . $producto->nombre);

        return redirect()->route('producto.index')->with('success', 'Producto actualizado exitosamente.');
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        // dd($producto);


        $p = producto::where('id',$id)->first();
        $p->delete();
        activity()
        ->causedBy(auth()->user()) // El usuario responsable de la actividad
        ->log('Se elimino un producto : ' . $p->nombre);
        return redirect()->route('producto.index')->with('success', 'Producto Eliminado con Exito');;
    }

    public function verproducto(Request $request)
    {
        $categorias = Categoria::all();
    $colores = Color::all();
        $productos = Producto::query();

        if ($request->has('categoria')) {
            $productos->where('categoria_id', $request->categoria);
        }

        if ($request->has('color')) {
            $productos->where('color_id', $request->color);
        }



        $productos = $productos->get();

        // Otras lógicas, como obtener las categorías, colores y tallas para los filtros

        return view('ver-productos', compact('productos', 'categorias', 'colores'));
    }
}
