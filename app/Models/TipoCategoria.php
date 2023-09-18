<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCategoria extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */

     protected $table = 'tipo_categorias';

     /**
      * The primary key associated with the table.
      *
      * @var int
      */
 
     protected $primaryKey = 'tic_id';
 
     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
 
     protected $fillable = [
         'tic_nombre',
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
         "tic_nombre" => "required | min:2 | max:30 | unique:tipo_categorias",
     ];
 
     /**
     * Get the categorias that owns the tipo_categorias.
     */
    public function categorias()
    {
        return $this->hasMany(Categoria::class, 'tic_id', 'tic_id');
    }
}
