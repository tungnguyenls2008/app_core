<?php

namespace App\Models\_Backend;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FeeConfig
 * @package App\Models
 * @version January 6, 2022, 5:42 pm +07
 *
 * @property string $merchant_id
 * @property integer $type
 * @property integer $fixed_fee
 * @property number $percentage_fee
 * @property integer $status
 */
class FeeConfig extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'fee_config';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $connection = "backend";

    public $fillable = [
        'merchant_id',
        'type',
//        'fixed_fee',
//        'percentage_fee',
        'applied_from',
        'fee_data',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'merchant_id' => 'string',
        'type' => 'integer',
        'fixed_fee' => 'integer',
        'percentage_fee' => 'float',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'merchant_id' => 'required|string|max:12',
        'type' => 'required|integer',
//        'fixed_fee' => 'required|integer',
//        'percentage_fee' => 'required|numeric',
        'status' => 'integer',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];


}
