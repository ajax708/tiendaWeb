@php

    use App\Models\producto;
    use App\Models\categoria;
    use Illuminate\Support\Str;
    $buscar = Request('buscar');

    $categorias = Categoria::with([
        'productos' => function ($query) use ($buscar) {
            $query->where('nombre', 'like', '%' . $buscar . '%');
        },
    ])
        // ->where('categoria', 'like', '%' . $buscar . '%')
        ->get();
@endphp
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet">

<div class="bg-white py-8">
    <div class="container mx-auto">

        <form action="" method="GET">
            <!-- Contenedor del buscador -->
            <div class="flex justify-center mb-8">
                <input type="text" name="buscar" placeholder="Buscar producto"
                    class="border border-gray-300 px-4 py-2 rounded-l-md w-64">
                <!--<a href="{{ route('dashboard') }}" class="bg-red-500 text-white px-4 py-2 ml-0.5">&times;</a>-->
                <button class="bg-blue-500 text-white px-3 py-2 rounded-r-md"><span class="material-symbols-outlined">search</span></button>
            </div>
        </form>

        <div class="container mx-auto px-4">
            @foreach ($categorias as $categoria)
            <h2 class="text-2xl font-extrabold text-gray-500 mt-8 mb-4 ml-4 uppercase tracking-wide font-montserrat">
                {{ $categoria->categoria }}
            </h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 px-4">
                @foreach ($categoria->productos as $producto)
                <div>
                    <a href="{{ route('producto.show', $producto) }}"
                        class="no-underline hover:no-underline bg-white rounded-2xl p-4 flex flex-col items-center transition transform duration-300 ease-in-out hover:-translate-y-1 hover:shadow-2xl">
                       <div class="relative">
                            @if (Storage::exists('public/' . $producto->imagen1))
                                <img src="{{ asset('storage/' . $producto->imagen1) }}" alt="Imagen del producto" class="w-full h-40 object-contain">
                            @else
                                <img src="{{ asset('img/logo-olf.png') }}" alt="Imagen por defecto" class="w-full h-40 object-contain">
                            @endif 
                            <div class="absolute top-2 right-2 py-1 px-1 rounded-full text-xs font-bold
                                @if ($producto->stock > 0)
                                    bg-green-500 text-white
                                @else
                                    bg-red-500 text-white
                                @endif
                            ">
                                @if ($producto->stock > 0)
                                    {{ $producto->stock }} disponibles
                                @else
                                    Agotado
                                @endif
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-black my-2">{{ $producto->nombre }}</h3>
                        <p class="text-gray-500">{{ Str::limit($producto->descripcion, 15) }}</p>
                        <p class="text-black font-bold text-xl my-2">Bs. {{ number_format($producto->precio, 2) }}</p>
                        <button class="mt-4 py-2 px-4
                            @if ($producto->stock > 0)
                                bg-green-500 text-white rounded-full hover:bg-green-600 hover:bg-green-600
                                transition duration-300 ease-in-out
                            @else
                                bg-red-500 text-white rounded-full hover:bg-red-600 hover:bg-red-600
                                transition duration-300 ease-in-out
                            @endif">
                            Comprar
                        </button>
                    </a>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
        
    </div>
</div>
