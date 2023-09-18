<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoria extends Model
{
    use HasFactory;

        /**
     * The table associated with the model.
     *
     * @var string
     */

     protected $table = 'sub_categorias';

     /**
      * The primary key associated with the table.
      *
      * @var int
      */
 
     protected $primaryKey = 'subc_id';
 
     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
 
     protected $fillable = [
         'subc_nombre',
         'cat_id'
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
         "subc_nombre" => "required | min:2 | max:30 | unique:sub_categorias",
         "cat_id" => "required",
     ];
 
    /**
     * Get the categorias that owns the sub_categorias.
     */
    public function categorias()
    {
        return $this->belongsTo(Categoria::class, 'cat_id', 'cat_id');
    }

    /**
     * Get the productos that owns the sub_categorias.
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'subc_id', 'subc_id');
    }
}
