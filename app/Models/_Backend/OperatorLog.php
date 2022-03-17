<?php

namespace App\Models\_Backend;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class OperatorLog
 * @package App\Models
 * @version January 24, 2022, 2:02 pm +07
 *
 * @property string $operator_id
 * @property string $function
 * @property string $content
 */
class OperatorLog extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'operator_log';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $connection = "backend";

    public $fillable = [
        'operator_id',
        'function',
        'content'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'function' => 'string',
        'content' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'function' => 'nullable|string|max:100',
        'operator_id' => 'required|string|max:500',
        'content' => 'required|string|max:500',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];


}
