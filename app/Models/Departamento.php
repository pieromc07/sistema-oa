<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'departamentos';

    /**
     * The primary key associated with the table.
     *
     * @var int
     */

    protected $primaryKey = 'dep_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'dep_nombre'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    
    public $timestamps = false;
}
