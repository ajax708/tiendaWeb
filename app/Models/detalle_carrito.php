<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\producto;
class detalle_carrito extends Model
{
    use HasFactory;
    
    public function producto()
    {
        return $this->belongsTo(producto::class, 'producto_id');
    }
}
