<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proveedor extends Model
{
    use HasFactory;

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'categoria_id');
    }

}
