<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'horarios';

    /**
     * The primary key associated with the table.
     *
     * @var int
     */

    protected $primaryKey = 'hor_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'hor_inicio',
        'hor_fin',
        'hor_formato'
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
        "hor_inicio" => "required | min:2 | max:30 | unique:horarios",
        "hor_fin" => "required | min:2 | max:30 | unique:horarios",
    ];

    /**
     * Get the citas that owns the horarios.
     */

    public function citas()
    {
        return $this->hasMany(Cita::class, 'hor_id', 'hor_id');
    }
}
