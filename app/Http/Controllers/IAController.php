<?php

namespace App\Http\Controllers;

use App\Models\producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Facades\Image;
use Storage;
use GuzzleHttp\Client;
use Exception;

class IAController extends Controller
{
  
         public function generarimagen($id){
            
            $producto = producto::find($id);

            return view('VistaProductos.genform', compact('producto'));
         }   
         public function generateIAImage(Request $request)
         {
             try {
                 $producto_id = $request->input('producto_id');
                 $prompt = $request->input('prompt');
     
                 // Obtener el producto por su ID
                 $producto = Producto::findOrFail($producto_id);
                 $imagePath = storage_path('app/public/' . $producto->imagen1);
     
                 if (!file_exists($imagePath)) {
                     throw new Exception("Image file does not exist: $imagePath");
                 }
     
                 // Generar fondo con OpenAI
                 $backgroundUrl = $this->generateBackground($prompt);
     
                 // Descargar la imagen de fondo generada
                 $backgroundContents = file_get_contents($backgroundUrl);
                 $background = imagecreatefromstring($backgroundContents);
     
                 // Redimensionar el fondo a 512x512 píxeles
                 $backgroundResized = imagescale($background, 512, 512);
     
                 // Cargar la imagen original
                 $originalImage = imagecreatefrompng($imagePath);
     
                 // Redimensionar la imagen original a 256x256 píxeles
                 $originalImageResized = imagescale($originalImage, 512, 512);
     
                 // Calcular las posiciones para centrar la imagen redimensionada en el fondo
                 $x = (imagesx($backgroundResized) - imagesx($originalImageResized)) / 2;
                 $y = (imagesy($backgroundResized) - imagesy($originalImageResized)) / 2;
     
                 // Combinar la imagen original redimensionada con el fondo
                 imagecopy($backgroundResized, $originalImageResized, $x, $y, 0, 0, imagesx($originalImageResized), imagesy($originalImageResized));
     
                 // Guardar la imagen combinada temporalmente
                 $combinedImagePath = 'public/temp/combined_' . basename($imagePath);
                 imagepng($backgroundResized, storage_path('app/' . $combinedImagePath));
     
                 // Liberar memoria
                 imagedestroy($background);
                 imagedestroy($backgroundResized);
                 imagedestroy($originalImage);
                 imagedestroy($originalImageResized);
     
                 return response()->json([
                     'success' => true,
                     'image_url' => Storage::url($combinedImagePath),
                 ]);
             } catch (Exception $e) {
                 \Log::error('Error generating IA image: ' . $e->getMessage(), ['exception' => $e]);
                 return response()->json([
                     'success' => false,
                     'message' => 'Error generating IA image.',
                     'error' => $e->getMessage()
                 ], 500);
             }
         }
     
         private function generateBackground($prompt)
         {
            $apiKey = env('OPENAI_API_KEY');
            $client = new \GuzzleHttp\Client();
        
            try {
                $response = $client->post('https://api.openai.com/v1/images/generations', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $apiKey,
                        'Content-Type' => 'application/json',
                    ],
                    'json' => [
                        'prompt' => $prompt,
                        'n' => 1,
                        'size' => '256x256'
                    ],
                ]);
        
                $body = json_decode((string) $response->getBody(), true);
        
                if (isset($body['data'][0]['url'])) {
                    return $body['data'][0]['url'];
                } else {
                    throw new Exception("No image URL returned from OpenAI.");
                }
            } catch (Exception $e) {
                \Log::error('Error generating background with OpenAI: ' . $e->getMessage(), ['exception' => $e]);
                throw new Exception("Failed to generate background with OpenAI.");
            }
         }


         public function guardarImagenIA(Request $request)
        {
            
            $producto_id = $request->input('producto_id');
            $image_url = $request->input('image_url');
    
            // Obtener el producto por su ID
            $producto = Producto::findOrFail($producto_id);
    
            // Ajustar la ruta de la imagen generada
            $relativeImagePath = str_replace(asset('storage'), 'storage', $image_url);
            $absoluteImagePath = public_path($relativeImagePath);
    
            if (!file_exists($absoluteImagePath)) {
                throw new Exception("Image file does not exist: $absoluteImagePath");
            }
    
            // Leer el contenido de la imagen
            $imageContents = file_get_contents($absoluteImagePath);
            $imageName = 'imagen4_' . time() . '.png';
            $imagePath = 'img/fotosProductos/' . $imageName;
    
            // Guardar la imagen utilizando Storage::disk('public')
            Storage::disk('public')->put($imagePath, $imageContents);
    
            // Verificar que la imagen se haya guardado correctamente
            if (!Storage::disk('public')->exists($imagePath)) {
                throw new Exception("Failed to save the image to the specified path: $imagePath");
            }
    
            // Actualizar el campo imagen4 con la ruta local de la imagen guardada
            $producto->imagen4 = $imagePath;
            $producto->save();
    
            return redirect()->route('producto.index')->with('success', 'Imagen guardada exitosamente.');
           
        }

}

