<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'marcas';

    /**
     * The primary key associated with the table.
     *
     * @var int
     */

    protected $primaryKey = 'mar_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'mar_nombre',
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
        "mar_nombre" => "required | min : 2 | max: 30 | unique:marcas"
    ];

    /**
     * Get the productos that owns the marcas.
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'mar_id', 'mar_id');
    }
}
