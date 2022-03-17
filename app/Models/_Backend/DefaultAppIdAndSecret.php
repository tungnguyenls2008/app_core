<?php

namespace App\Models\_Backend;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class DefaultAppIdAndSecret
 * @package App\Models
 * @version January 17, 2022, 9:35 am +07
 *
 * @property integer $type
 * @property string $app_id
 * @property string $secret
 */
class DefaultAppIdAndSecret extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'default_app_id_and_secret';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $connection = "backend";

    public $fillable = [
        'type',
        'app_id',
        'secret'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'type' => 'integer',
        'app_id' => 'string',
        'secret' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'type' => 'required|integer',
        'app_id' => 'required|string|max:8',
        'secret' => 'required|string|max:32',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];


}
