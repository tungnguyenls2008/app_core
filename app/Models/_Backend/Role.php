<?php

namespace App\Models\_Backend;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Role
 * @package App\Models
 * @version December 15, 2021, 8:50 am +07
 *
 * @property string $description
 * @property string $route
 * @property integer $status
 */
class Role extends Model
{
    use SoftDeletes;

    use HasFactory;
    public $connection = "backend";

    public $table = 'role';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'description',
        'route',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'description' => 'string',
        'route' => 'string',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'description' => 'required|string|max:500',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable',
    ];


}
