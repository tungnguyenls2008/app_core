<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class TestCallback
 * @package App\Models
 * @version January 25, 2022, 9:38 pm +07
 *
 * @property string $request
 */
class TestCallback extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'test_callback';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'request',
        'signature'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'request' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'request' => 'required|string',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];


}
