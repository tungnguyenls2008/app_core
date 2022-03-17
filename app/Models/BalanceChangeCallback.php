<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class BalanceChangeCallback
 * @package App\Models
 * @version December 29, 2021, 9:08 am +07
 *
 * @property string $request
 * @property string $response
 * @property integer $amount
 * @property string $tranDate
 * @property string $tranId
 * @property string $numberOfBeneficiary
 * @property integer $callback_id
 * @property integer $fee
 * @property string $description
 * @property string $cardId
 */
class BalanceChangeCallback extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'epg_callback';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'request',
        'response',
        'amount',
        'tranDate',
        'tranId',
        'type',
        'numberOfBeneficiary',
        'merchant_id',
        'callback_id',
        'fee',
        'description',
        'cardId',
        'current_balance',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'request' => 'string',
        'response' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'request' => 'required|string',
        'response' => 'required|string',
        'created_at' => 'required',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];


}
