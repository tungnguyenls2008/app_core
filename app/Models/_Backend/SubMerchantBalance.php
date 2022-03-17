<?php

namespace App\Models\_Backend;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SubMerchantBalance
 * @package App\Models
 * @version January 19, 2022, 2:11 pm +07
 *
 * @property string $merchant_id
 * @property integer $amount
 */
class SubMerchantBalance extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'sub_merchant_balance';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $connection = "backend";

    public $fillable = [
        'merchant_id',
        'amount',
        'ft_code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'merchant_id' => 'string',
        'ft_code' => 'string',
        'amount' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'merchant_id' => 'required|string|max:10',
        'ft_code' => 'required|string|max:100',
        'amount' => 'required|integer',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];


}
