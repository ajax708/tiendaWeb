<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;

use App\Models\carrito;
use App\Models\categoria;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Talla;
use App\Models\color;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->roles();
        $this->cargarUsuarios();
        $this->cargarCategoria();
        $this->cargarColores();
    }
    public function roles(){
        $administrador            = Role::create(['name' => 'administrador']);
        $cliente        = Role::create(['name' => 'cliente']);
        $vendedor    = Role::create(['name' => 'vendedor']);
        ////////////ADMIN
        Permission::create(['name' => 'AdmUsuario'])->syncRoles([$administrador]);
        ////////////ROLES
        Permission::create(['name' => 'AdmCompra'])->syncRoles([$administrador, $vendedor]);
        Permission::create(['name' => 'AdmVenta'])->syncRoles([$vendedor, $cliente]);
        Permission::create(['name' => 'AdmProductos'])->syncRoles([$administrador]);
        ////////////
    }
    public function cargarUsuarios(){

        $user = new User();
        //$user->id = 1;
        $user->name =  'Admin Andres';
        $user->email =  'andres@gmail.com';
        $user->password = bcrypt('12345678');
        $user->profile_photo_path = 'img/default.png';
        $user->assignRole('administrador');
        $user->save();

        $carrito = new carrito();
        $carrito->cliente_id = $user->id;
        $carrito->total = 0;
        $carrito->estado = 'pendiente';
        $carrito->save();


        $user = new User();
        //$user->id = 2;
        $user->name =  'vendedor';
        $user->email =  'vendedor@gmail.com';
        $user->password = bcrypt('12345678');
        $user->profile_photo_path = 'img/default.png';
        $user->assignRole('vendedor');
        $user->save();

        $carrito = new carrito();
        $carrito->cliente_id = $user->id;
        $carrito->total = 0;
        $carrito->estado = 'pendiente';
        $carrito->save();

        $user = new User();
        //$user->id = 3;
        $user->name =  'cliente';
        $user->email =  'cliente@gmail.com';
        $user->password = bcrypt('12345678');
        $user->profile_photo_path = 'img/default.png';
        $user->assignRole('cliente');
        
        $user->save();

        $carrito = new carrito();
        $carrito->cliente_id = $user->id;
        $carrito->total = 0;
        $carrito->estado = 'pendiente';
        $carrito->save();

        
    }
    public function cargarTalla(){

        //POR NUMERO------------------------------------------
        $talla = new Talla();
        $talla->tipo_talla_letra = '';
        $talla->tipo_talla_numero = '36';
        $talla->save();

        $talla = new Talla();
        $talla->tipo_talla_letra = '';
        $talla->tipo_talla_numero = '37';
        $talla->save();

        $talla = new Talla();
        $talla->tipo_talla_letra = '';
        $talla->tipo_talla_numero = '38';
        $talla->save();

        $talla = new Talla();
        $talla->tipo_talla_letra = '';
        $talla->tipo_talla_numero = '39';
        $talla->save();

        $talla = new Talla();
        $talla->tipo_talla_letra = '';
        $talla->tipo_talla_numero = '40';
        $talla->save();

        $talla = new Talla();
        $talla->tipo_talla_letra = '';
        $talla->tipo_talla_numero = '41';
        $talla->save();

        $talla = new Talla();
        $talla->tipo_talla_letra = '';
        $talla->tipo_talla_numero = '42';
        $talla->save();

        $talla = new Talla();
        $talla->tipo_talla_letra = '';
        $talla->tipo_talla_numero = '43';
        $talla->save();

        $talla = new Talla();
        $talla->tipo_talla_letra = '';
        $talla->tipo_talla_numero = '44';
        $talla->save();

        $talla = new Talla();
        $talla->tipo_talla_letra = '';
        $talla->tipo_talla_numero = '45';
        $talla->save();

        $talla = new Talla();
        $talla->tipo_talla_letra = '';
        $talla->tipo_talla_numero = '46';
        $talla->save();

        $talla = new Talla();
        $talla->tipo_talla_letra = '';
        $talla->tipo_talla_numero = '47';
        $talla->save();

        //-----POR LETRAS--------------------------------------
        $talla = new Talla();
        $talla->tipo_talla_letra = 'XXS';
        $talla->tipo_talla_numero = '';
        $talla->save();

        $talla = new Talla();
        $talla->tipo_talla_letra = 'XS';
        $talla->tipo_talla_numero = '';
        $talla->save();

        $talla = new Talla();
        $talla->tipo_talla_letra = 'S';
        $talla->tipo_talla_numero = '';
        $talla->save();

        $talla = new Talla();
        $talla->tipo_talla_letra = 'M';
        $talla->tipo_talla_numero = '';
        $talla->save();

        $talla = new Talla();
        $talla->tipo_talla_letra = 'L';
        $talla->tipo_talla_numero = '';
        $talla->save();

        $talla = new Talla();
        $talla->tipo_talla_letra = 'XL';
        $talla->tipo_talla_numero = '';
        $talla->save();

        $talla = new Talla();
        $talla->tipo_talla_letra = 'XXL';
        $talla->tipo_talla_numero = '';
        $talla->save();

        $talla = new Talla();
        $talla->tipo_talla_letra = 'XXXL';
        $talla->tipo_talla_numero = '';
        $talla->save();

    }

    
    public function cargarColores(){
        //Colores de la prenda
        color::create(['nombre' => 'Hierro fundido']);
        color::create(['nombre' => 'Acero Inoxidable']);
        color::create(['nombre' => 'Alumnio']);
        color::create(['nombre' => 'Hierro']);
        color::create(['nombre' => 'Cobre']);
    }
    public function cargarCategoria(){

        $cat = new categoria();
        $cat->categoria = 'Parrillas';
        $cat->save();

        $cat = new categoria();
        $cat->categoria = 'Hornos';
        $cat->save();

        $cat = new categoria();
        $cat->categoria = 'Pizzeros';
        $cat->save();

        $cat = new categoria();
        $cat->categoria = 'Caja China';
        $cat->save();

        $cat = new categoria();
        $cat->categoria = 'Espiadero';
        $cat->save();

        $cat = new categoria();
        $cat->categoria = 'Freidoras';
        $cat->save();

        $cat = new categoria();
        $cat->categoria = 'Planchas';
        $cat->save();

        $cat = new categoria();
        $cat->categoria = 'Carritos';
        $cat->save();

        $cat = new categoria();
        $cat->categoria = 'Cocinas';
        $cat->save();

    }
}
