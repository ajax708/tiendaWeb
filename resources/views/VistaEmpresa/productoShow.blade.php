<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Título de tu Página</title>
    <script src="https://preview.babylonjs.com/babylon.js"></script>
    <script src="https://preview.babylonjs.com/loaders/babylonjs.loaders.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        #renderCanvas {
            width: 100%;
            height: 100%;
        }
        .lds-spinner {
            color: official;
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }
        .lds-spinner div {
            transform-origin: 40px 40px;
            animation: lds-spinner 1.2s linear infinite;
        }
        .lds-spinner div:after {
            content: " ";
            display: block;
            position: absolute;
            top: 3px;
            left: 37px;
            width: 6px;
            height: 18px;
            border-radius: 20%;
            background: #3498db;
        }
        .lds-spinner div:nth-child(1) {
            transform: rotate(0deg);
            animation-delay: -1.1s;
        }
        .lds-spinner div:nth-child(2) {
            transform: rotate(30deg);
            animation-delay: -1s;
        }
        .lds-spinner div:nth-child(3) {
            transform: rotate(60deg);
            animation-delay: -0.9s;
        }
        .lds-spinner div:nth-child(4) {
            transform: rotate(90deg);
            animation-delay: -0.8s;
        }
        .lds-spinner div:nth-child(5) {
            transform: rotate(120deg);
            animation-delay: -0.7s;
        }
        .lds-spinner div:nth-child(6) {
            transform: rotate(150deg);
            animation-delay: -0.6s;
        }
        .lds-spinner div:nth-child(7) {
            transform: rotate(180deg);
            animation-delay: -0.5s;
        }
        .lds-spinner div:nth-child(8) {
            transform: rotate(210deg);
            animation-delay: -0.4s;
        }
        .lds-spinner div:nth-child(9) {
            transform: rotate(240deg);
            animation-delay: -0.3s;
        }
        .lds-spinner div:nth-child(10) {
            transform: rotate(270deg);
            animation-delay: -0.2s;
        }
        .lds-spinner div:nth-child(11) {
            transform: rotate(300deg);
            animation-delay: -0.1s;
        }
        .lds-spinner div:nth-child(12) {
            transform: rotate(330deg);
            animation-delay: 0s;
        }
        @keyframes lds-spinner {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }
    </style>
    <!-- Agregar en la cabecera de tu plantilla principal si Bootstrap no está incluido -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery y Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
@extends('dashboard')

@section('cliente')
    <div class="container mx-auto">
        
        <div class="bg-gray-200 shadow-md rounded p-4 lg:p-8 mt-4">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
                <!-- Carrusel de imágenes y video -->
                <div>
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="2000">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                        </ol>
                        <div class="carousel-inner">
                            @foreach ([$p->imagen1, $p->imagen2, $p->imagen3, $p->imagen4] as $index => $image)
                                @if (!$image)
                                    @continue
                                @endif
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ asset( 'storage/' . $image) }}" class="d-block w-100" alt="Foto del producto {{ $index + 1 }}">
                                </div>
                            @endforeach
                            @if ($p->video)
                                <div class="carousel-item">
                                    <video class="d-block w-100" controls>
                                        <source src="{{ asset('storage/' . $p->video) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            @endif
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                

                <div class="space-y-4">
                    <h3 class="text-2xl font-medium text-gray-800">{{ $p->nombre }}</h3>
                    <h3 class="text-2x2 font-medium text-gray-800">BOB. {{ $p->precio }}</h3>
                    <p class="text-sm text-gray-600">Cantidad disponible: {{ $p->stock }}</p>
                    <p class="text-gray-600">{{ $p->descripcion }}</p>
                    
                    @auth
                        @if($p->stock > 0)
                        <form action="{{ route('carrito.update', $p->id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="producto_id" value="{{ $p->id }}">
                            <input type="hidden" name="producto_precio" value="{{ $p->precio }}">
                            @if ($p->stock > 0)
                            <div class="flex items-center">
                                <input type="number" name="cantidad" placeholder="Cantidad" required min="1" max="{{ $p->stock }}" class="border border-gray-300 px-4 py-2 rounded-l-md w-32">
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-r-md hover:bg-green-600 transition duration-300">Agregar al Carrito</button>
                            </div>
                            @else
                            <div class="flex items-center">
                                <span class="text-red-500 text-sm font-bold">No disponible</span>
                            </div>
                            @endif
                        </form>
                        @else
                        <h3 class="text-2x2 font-medium text-gray-800">No hay Stock</h3>
                        @endif
                        <!-- Botón para abrir el modal, con ruta del modelo 3D -->
                        
                        @if ($p->es_3d)
                            <button type="button" class="bg-blue-500 text-white font-bold py-2 px-4 rounded" data-toggle="modal" data-target="#model3DModal">
                                Ver en 3D
                            </button>                        
                            <p class="text-sm text-gray-600">Descripción: {{ $p->descripcion_3d }}</p>
                            <p class="text-sm text-gray-600">Precio del modelo 3D: {{ $p->precio_3d }}</p>
                            @if($p->es_formato_obj)
                            <p class="text-sm text-gray-600">-Formato: Obj</p>
                            @endif
                            @if($p->es_formato_gltf)
                            <p class="text-sm text-gray-600">-Formato gltF</p>
                            @endif
                            @if($p->es_formato_fbx)
                            <p class="text-sm text-gray-600">-Formato FBX</p>
                            @endif
                            @if($p->es_formato_stl)
                            <p class="text-sm text-gray-600">-Formato STL</p>
                            @endif
                            <form action="{{ route('session2') }}" method="POST">
                                @csrf
                                <input type="text" name="producto" hidden value="{{ $p->id }}">
                                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
                                    Comprar modelo 3D ahora
                                </button>
                            </form>                            
                        @endif
                    @else
                        <p class="text-red-600 bg-red-100 border border-red-600 rounded-md px-4 py-2">Inicia sesión para poder comprar</p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    <x-welcome />

    <!-- Modal for 3D Model Viewing -->
    <div class="modal fade" id="model3DModal" tabindex="-1" role="dialog" aria-labelledby="model3DModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="model3DModalLabel">Modelo 3D</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="loadingSpinner" class="flex justify-center items-center" style="display: none;">
                        <div class="lds-spinner">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                    <canvas id="renderCanvas" style="display: none;"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    $(document).ready(function(){
        $('#carouselExampleIndicators').carousel({
            interval: 2000 // Ajusta este valor para cambiar la velocidad (2000 ms = 2 segundos)
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        $('#model3DModal').on('shown.bs.modal', function () {

            


            const canvas = document.getElementById('renderCanvas');
            const loadingSpinner = document.getElementById('loadingSpinner');
            if (!canvas || !loadingSpinner) {
                console.error('3D canvas or spinner not found');
                return;
            }

            // Mostrar el spinner
            loadingSpinner.style.display = 'flex';
            canvas.style.display = 'none';

            // Crear el engine y la escena
            const engine = new BABYLON.Engine(canvas, true);
            const scene = new BABYLON.Scene(engine);

            scene.clearColor = new BABYLON.Color4(0.8, 0.8, 0.8, 1); // (R, G, B, A)


            // Crear la cámara
            const camera = new BABYLON.ArcRotateCamera("camera", Math.PI/4 ,Math.PI /2 , 4, new BABYLON.Vector3(0, 1, 0), scene);
            camera.attachControl(canvas, true);

            // Crear la luz
            const light = new BABYLON.HemisphericLight("light", new BABYLON.Vector3(-3, 1, 3), scene);
            const light2 = new BABYLON.HemisphericLight("light2", new BABYLON.Vector3(3, 1, 3), scene);

            // Cargar el modelo
            const modelPath = `{{ asset('storage/' . $p->archivo_3d) }}`;
            BABYLON.SceneLoader.Append("", modelPath, scene, function (scene) {
                // Ocultar el spinner y mostrar el canvas cuando el modelo se haya cargado
                loadingSpinner.style.display = 'none';
                canvas.style.display = 'block';
                
                engine.runRenderLoop(function () {
                    scene.render();
                });
            }, null, function (scene, message) {
                console.error('Error loading model:', message);
                // Ocultar el spinner incluso si hay un error
                loadingSpinner.style.display = 'none';
            });

            // Ajustar el tamaño del canvas al cambiar el tamaño de la ventana
            window.addEventListener('resize', function () {
                engine.resize();
            });

            // Cleanup on modal close
            $('#model3DModal').on('hidden.bs.modal', function () {
                engine.dispose();
            });
        });
    });
</script>
</body>
</html>
