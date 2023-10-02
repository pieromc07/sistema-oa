<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'ventas';

    /**
     * The primary key associated with the table.
     *
     * @var int
     */
    protected $primaryKey = 'ven_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cli_id',
        'usu_id',
        'met_id',
        'ven_fecha',
        'ven_total',
        'ven_subtotal',
        'ven_impuesto',
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
        "cli_id" => "required | integer | min:1",
        "usu_id" => "required | integer | min:1",
        "met_id" => "required | integer | min:1",
        "ven_fecha" => "required | date",
        "ven_total" => "required | numeric | min:0",
        "ven_subtotal" => "required | numeric | min:0",
        "ven_impuesto" => "required | numeric | min:0",
    ];

    /**
     * Get the cliente that owns the venta.
     */

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'cli_id', 'cli_id');
    }

    /**
     * Get the usuario that owns the venta.
     */

    public function usuario(){
        return $this->belongsTo(User::class, 'usu_id', 'usu_id');
    }

    /**
     * Get the metodo_pago that owns the venta.
     */

    public function metodo_pago(){
        return $this->belongsTo(MetodoPago::class, 'met_id', 'met_id');
    }
}
