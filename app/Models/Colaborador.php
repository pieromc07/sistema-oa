<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'colaboradores';

    /**
     * The primary key associated with the table.
     *
     * @var int
     */

    protected $primaryKey = 'col_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'col_apellido_paterno',
        'col_apellido_materno',
        'col_nombres',
        'tdo_id',
        'col_numero_documento',
        'col_direccion',
        'col_celular',
        'dis_id',
        'pue_id',
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
        "tdo_id" => "required",
        "col_numero_documento" => "required | min:8 | unique:colaboradores",
        "col_nombres" => "required | max:255",
        "col_apellido_paterno" => "required | max:255",
        "col_apellido_materno" => "required | max:255",
        "col_direccion" => "nullable | max:255",
        "col_celular" => "nullable | max:9 | min:9",
        "dep_id" => "required",
        "pro_id" => "required",
        "dis_id" => "required",
        "pue_id" => "required",
    ];

    /**
     *  Relationship
     */

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tdo_id', 'tdo_id');
    }

    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'dis_id', 'dis_id');
    }

    public function usuario()
    {
        return $this->hasOne(User::class, 'col_id', 'col_id');
    }

    public function puesto()
    {
        return $this->belongsTo(Puesto::class, 'pue_id', 'pue_id');
    }
}
