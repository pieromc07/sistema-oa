<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'unidad_medidas';

    /**
     * The primary key associated with the table.
     *
     * @var int
     */

    protected $primaryKey = 'unm_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'unm_nombre',
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
        "unm_nombre" => "required | min : 2 | max: 30 | unique:unidad_medidas"
    ];

    /**
     * Get the productos that owns the unidad_medidas.
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'unm_id', 'unm_id');
    }
}
