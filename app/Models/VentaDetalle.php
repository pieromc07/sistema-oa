<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'venta_detalles';

    /**
     * The primary key associated with the table.
     *
     * @var int
     */

    protected $primaryKey = 'vde_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'ven_id',
        'pro_id',
        'vde_cantidad',
        'vde_precio',
        'vde_subtotal',
        'vde_impuesto',
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
        "ven_id" => "required | integer | min:1",
        "pro_id" => "required | integer | min:1",
        "vde_cantidad" => "required | integer | min:1",
        "vde_precio" => "required | numeric | min:0",
        "vde_subtotal" => "required | numeric | min:0",
        "vde_impuesto" => "required | numeric | min:0",
    ];

    /**
     *  Relationship
     */

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'ven_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'pro_id');
    }

    /**
     *  Accessors
     */

    public function getVdePrecioAttribute($value)
    {
        return number_format($value, 2, '.', '');
    }

    public function getVdeSubtotalAttribute($value)
    {
        return number_format($value, 2, '.', '');
    }

    public function getVdeImpuestoAttribute($value)
    {
        return number_format($value, 2, '.', '');
    }

    /**
     *  Mutators
     */

    public function setVdePrecioAttribute($value)
    {
        $this->attributes['vde_precio'] = number_format($value, 2, '.', '');
    }

    public function setVdeSubtotalAttribute($value)
    {
        $this->attributes['vde_subtotal'] = number_format($value, 2, '.', '');
    }

    public function setVdeImpuestoAttribute($value)
    {
        $this->attributes['vde_impuesto'] = number_format($value, 2, '.', '');
    }

    /**
     *  Scopes
     */

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->whereHas('producto', function ($query) use ($search) {
                $query->where('pro_nombre', 'LIKE', "%$search%");
            });
        }
    }

    public function scopeSearchByVenta($query, $search)
    {
        if ($search) {
            return $query->whereHas('venta', function ($query) use ($search) {
                $query->where('ven_serie', 'LIKE', "%$search%")
                    ->orWhere('ven_numero', 'LIKE', "%$search%");
            });
        }
    }
}
