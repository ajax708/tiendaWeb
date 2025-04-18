<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    use HasFactory;

    public function categoria()
    {
        return $this->belongsTo(categoria::class);
    }
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }
    public function stock()
    {
    return $this->hasOne(Stock::class);
    }
    public function talla()
    {
        return $this->belongsTo(Talla::class, 'talla_id');
    }
    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
