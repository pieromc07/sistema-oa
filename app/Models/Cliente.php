<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clientes';

    /**
     * The primary key associated with the table.
     *
     * @var int
     */

    protected $primaryKey = 'cli_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'cli_nombre_completo',
        'tdo_id',
        'cli_numero_documento',
        'cli_direccion',
        'cli_celular',
        'cli_contraseña',
        'dis_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */

    protected $hidden = [
        'cli_contraseña',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Rules for validation
     */

    public static $rules = [
        "tdo_id" => "required",
        "cli_numero_documento" => "required | min:8 | unique:clientes",
        "cli_nombre_completo" => "required | max:300",
        "cli_direccion" => "max:255",
        "cli_celular" => "max:255",
        "dis_id" => "required",
    ];

    /**
     * Get the tipo_documento that owns the cliente.
     */
    public function tipo_documento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tdo_id');
    }

    /**
     * Get the distrito that owns the cliente.
     */
    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'dis_id');
    }

    /**
     * Get the ventas for the cliente.
     */

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'cli_id', 'cli_id');
    }

    /**
     * Get the citas for the cliente.
     */

    public function citas()
    {
        return $this->hasMany(Cita::class, 'cli_id', 'cli_id');
    }
}
