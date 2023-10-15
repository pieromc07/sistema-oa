<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'citas';

    /**
     * The primary key associated with the table.
     *
     * @var int
     */

    protected $primaryKey = 'cit_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'cli_id',
        'col_id',
        'hor_id',
        'cit_fecha'
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
        "cli_id" => "required",
        "col_id" => "required",
        "hor_id" => "required",
        "cit_fecha" => "required"
    ];

    /**
     * Get the clientes that owns the citas.
     */

    public function clientes()
    {
        return $this->belongsTo(Cliente::class, 'cli_id', 'cli_id');
    }

    /**
     * Get the colaboradores that owns the citas.
     */

    public function colaboradores()
    {
        return $this->belongsTo(Colaborador::class, 'col_id', 'col_id');
    }

    /**
     * Get the horarios that owns the citas.
     */

    public function horarios()
    {
        return $this->belongsTo(Horario::class, 'hor_id', 'hor_id');
    }
}
