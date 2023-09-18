<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */

     protected $table = 'categorias';

     /**
      * The primary key associated with the table.
      *
      * @var int
      */
 
     protected $primaryKey = 'cat_id';
 
     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
 
     protected $fillable = [
         'cat_nombre',
         'tic_id'
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
         "cat_nombre" => "required | min:2 | max:30 | unique:categorias",
         "tic_id" => "required",
     ];
 
     /**
     * Get the tipo_categorias that owns the categorias.
     */
    public function tipo_categorias()
    {
        return $this->belongsTo(TipoCategoria::class, 'tic_id', 'tic_id');
    }

    /**
     * Get the sub_categorias that owns the categorias.
     */
    public function subcategorias()
    {
        return $this->hasMany(SubCategoria::class, 'cat_id', 'cat_id');
    }
}
