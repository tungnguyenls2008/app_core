<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class MerchantBankAccount
 * @package App\Models
 * @version January 6, 2022, 9:57 am +07
 *
 * @property integer $merchant_id
 * @property string $account_number
 * @property integer $bank_id
 */
class MerchantBankAccount extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'merchant_bank_account';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'merchant_id',
        'account_number',
        'bank_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'merchant_id' => 'string',
        'account_number' => 'string',
        'bank_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        //'merchant_id' => 'required|integer',
        'account_number' => 'required|unique:merchant_bank_account|string|max:24',
        'bank_id' => 'required|integer',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];


}
