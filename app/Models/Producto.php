<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */

     protected $table = 'productos';

     /**
      * The primary key associated with the table.
      *
      * @var int
      */

     protected $primaryKey = 'pro_id';

     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */

     protected $fillable = [
        'pro_nombre',
        'pro_descripcion',
        'pro_stock',
        'pro_stock_minimo',
        'pro_codigo_barra',
        'pro_precio_venta',
        'pro_precio_compra',
        'pro_fecha_vencimiento',
        'cat_id',
        'mar_id',
     ];

     /**
      * Indicates if the model should be timestamped.
      *
      * @var bool
      */
     public $timestamps = false;

     /**
      *  Rules for validation
      */
     public static $rules = [
        "pro_nombre" => "required | min : 2 | max: 30 | unique:productos",
        "pro_descripcion" => "max: 255",
        "pro_stock" => "required | min : 1 | max: 10",
        "pro_stock_minimo" => "",
        "pro_codigo_barra" => "required | min : 1 | max: 30",
        "pro_precio_venta" => "required | min : 1",
        "pro_precio_compra" => "",
        "pro_fecha_vencimiento" => "",
        "cat_id" => "required",
        "mar_id" => "required",
     ];

    /**
     * Get the productos that owns the categorias.
     */
    public function categoria(){
        return $this->belongsTo(Categoria::class, 'cat_id', 'cat_id');
    }
    /**
     * Get the productos that owns the marcas.
     */
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'mar_id', 'mar_id');
    }
}
