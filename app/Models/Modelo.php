<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'modelos';

    /**
     * The primary key associated with the table.
     *
     * @var int
     */
 
    protected $primaryKey = 'mod_id';
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
 
    protected $fillable = [
        'mod_nombre',
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
        "mod_nombre" => "required | min : 2 | max: 30 | unique:modelos"
    ];
 
    /**
     * Get the productos that owns the modelos.
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'mod_id', 'mod_id');
    }
}
