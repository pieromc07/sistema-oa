<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */

     protected $table = 'metodo_pagos';

     /**
      * The primary key associated with the table.
      *
      * @var int
      */

     protected $primaryKey = 'met_id';

     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */

     protected $fillable = [
         'met_nombre',
         'met_descripcion',
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
         "met_nombre" => "required | min:2 | max:50 | unique:metodo_pagos",
         "met_descripcion" => "required | min:2 | max:100",
     ];

     /**
     * Get the ventas that owns the metodo_pagos.
     */
    public function ventas(){
        return $this->hasMany(Venta::class, 'met_id', 'met_id');
    }
}
