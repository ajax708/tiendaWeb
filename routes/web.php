<?php

use App\Http\Controllers\AdministracionController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\IAController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\Permiso;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\Roles;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\EfectivoController;
use App\Http\Controllers\TallaController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {   return view('welcome'); })->name('welcome');


Route::get('/', [EfectivoController::class,'vistawelcome'])->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {});

Route::get('/dashboard', [EfectivoController::class,'vistawelcome'])->name('dashboard');

//Route::get('/ver-producto', function () {return view('ver-productos');})->name('ver-producto');
Route::get('/ver-producto', [ProductoController::class,'verproducto'])->name('ver-producto');

Route::resource('permisos', Permiso::class);
Route::resource('rol', Roles::class);
Route::resource('empresa', EmpresaController::class);

Route::resource('venta', VentaController::class);
Route::post('/venta/store', 'VentaController@storee')->name('venta.storee');
Route::post('/venta2', 'App\Http\Controllers\VentaController@store2')->name('venta.store2');

Route::get('rol/{role}/assign-permissions', [Roles::class, 'assignPermissions'])->name('rol.assign_permissions');
Route::put('rol/{role}/update-permissions', [Roles::class, 'updatePermissions'])->name('rol.update_permissions');

Route::get('user/{user}/assign-role', [UserController::class, 'assignRole'])->name('user.assign_role');
Route::put('user/{user}/update-role', [UserController::class, 'updateRole'])->name('user.update_role');

Route::resource('bitacora',BitacoraController::class);

Route::get('/bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');

Route::get('/mostrar-compras', [VentaController::class, 'mostrarCompras'])->name('mostrar.compras');

Route::get('notaVenta/{id}', [VentaController::class, 'notaVenta'])->name('notaVenta');
Route::get('notaCompra/{id}', [CompraController::class, 'notaCompra'])->name('notaCompra');
Route::resource('user',UserController::class);
Route::resource('producto', ProductoController::class);


Route::resource('categoria', CategoriaController::class);
Route::resource('marca',MarcaController::class);
Route::resource('color',ColorController::class);
Route::resource('talla',TallaController::class);
Route::resource('stock',StockController::class);
Route::resource('proveedor',ProveedorController::class);
Route::resource('compra', CompraController::class);
Route::resource('carrito', CarritoController::class)->except(['update']);
Route::put('carrito$carrito', [CarritoController::class, 'update'])->name('carrito.update');

Route::post('/session', 'App\Http\Controllers\StripeController@session')->name('session');
Route::get('/success', 'App\Http\Controllers\StripeController@success')->name('success');

Route::post('/session2', 'App\Http\Controllers\StripeController@session2')->name('session2');
Route::get('/success2/{id}', 'App\Http\Controllers\StripeController@success2')->name('success2');


Route::post('/generate-ia-image', [IAController::class, 'generateIAImage'])->name('generarImagenIA');

Route::get('/generar-imagen/{id}', 'App\Http\Controllers\IAController@generarimagen')->name('generarimagen');

Route::post('/guardar-imagen-ia', [IAController::class, 'guardarImagenIA'])->name('guardarImagenIA');


Route::resource('pedido', PedidoController::class)->except(['update']);
// Route::put('pedido$pedido', [PedidoController::class, 'update'])->name('.update');

Route::get('/pagoefectivo', [EfectivoController::class,'mostrarPagoEfectivo'])->name('continuarefectivo');
