@extends('dashboard')

@section('cliente')
<div class="relative bg-cover bg-center bg-opacity-60" style="background-image: url('{{ asset('img/fondo-principal.jpg') }}');">
    <div class="bg-black bg-opacity-40 absolute inset-0"></div>
    <div class="container mx-auto py-20 text-center relative z-10 text-white">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold leading-tight">
            Refracgas
        </h1>
        <p class="mt-4 text-2xl sm:text-3xl md:text-4xl font-medium">
        </p>
    </div>
</div>

<div class="bg-white py-12">
    <div class="container mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        <div class="text-center">
            <i class="fas fa-paw text-3xl text-blue-500"></i>
            <h2 class="text-xl sm:text-2xl font-bold mt-4">Atención Personalizada</h2>
            <p class="text-gray-600 mt-2">
                Estamos aquí para ayudarte a encontrar la ropa perfecta para ti.
            </p>
        </div>
        <div class="text-center">
            <i class="fas fa-stethoscope text-3xl text-blue-500"></i>
            <h2 class="text-xl sm:text-2xl font-bold mt-4">Productos Actualizados</h2>
            <p class="text-gray-600 mt-2">
                Descubre los productos s más modernas para mantener tu estilo actualizado.
            </p>
        </div>
        <div class="text-center">
            <i class="fas fa-heart text-3xl text-blue-500"></i>
            <h2 class="text-xl sm:text-2xl font-bold mt-4">Calidad y Estilo</h2>
            <p class="text-gray-600 mt-2">
                Cada prenda está diseñada con atención a los detalles y calidad excepcional.
            </p>
        </div>
    </div>
</div>

<div class="bg-white py-8">
    <div class="container mx-auto text-center">
        <h2 class="text-4xl font-bold mb-4">Productos</h2>
    </div>
    <div class="container mx-auto grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 px-4">
        @foreach ($productos as $producto)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <a href="{{ route('producto.show', $producto) }}"
                class="bg-white rounded-lg p-4 flex flex-col items-center hover:bg-dbb6ee transition duration-300 ease-in-out transform hover:-translate-y-1">
                <div class="relative">
                    <img src="{{ asset('storage/' . $producto->imagen1) }}" alt="Foto del producto" class="w-full h-40 object-contain">
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
                    @if ($producto->es_3d)
                        <div class="absolute top-2 left-2 py-1 px-2 rounded-full text-xs font-bold bg-blue-500 text-white">
                            3D
                        </div>
                    @endif
                </div>
                <h3 class="text-lg font-bold text-black my-2">{{ $producto->nombre }}</h3>
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
    <!-- Botón "Ver más productos" que lleva a la página de todos los productos -->
    <div class="text-center mt-8">
        <a href="{{ route('ver-producto') }}" class="inline-block px-4 py-2 text-white bg-blue-500 rounded-full hover:bg-blue-600 transition duration-300">
            Ver más productos
        </a>
    </div>
</div>
</div>

<!-- Sección de Contacto -->
<section class="bg-gray-100 p-16">
    <div class="container mx-auto flex items-center justify-between">
        <div class="w-1/2">
            <h2 class="text-3xl font-semibold mb-4">Contáctanos</h2>
            <p class="text-gray-700 leading-relaxed">Estamos aquí para ayudarte con tus necesidades. ¡Contáctanos para obtener más información!</p>
            <ul class="mt-4 space-y-2">
                <li class="flex items-center">
                    <i class="fas fa-phone text-lg text-blue-500 mr-2"></i> (+591) 7000-1234
                </li>
                <li class="flex items-center">
                    <i class="fas fa-envelope text-lg text-blue-500 mr-2"></i> info@stylostore.com
                </li>
                <li class="flex items-center">
                    <i class="fas fa-map-marker-alt text-lg text-blue-500 mr-2"></i> Dirección: Santa Cruz de la sierra - Bolivia, Av. Libertad
                </li>
            </ul>
        </div>
        <div class="w-1/4">
            <img src="{{ asset('img/contacto.png') }}" alt="Imagen de contacto" class="rounded-lg shadow-lg">
        </div>
    </div>
</section>

<!-- Pie de Página -->
<footer class="bg-blue-500 text-white py-3 text-center">
    <div class="container mx-auto">
        <p>&copy; 2023 Refracgas. Todos los derechos reservados.</p>
    </div>
</footer>
@endsection
