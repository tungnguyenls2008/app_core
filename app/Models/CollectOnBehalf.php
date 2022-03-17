<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class CollectOnBehalf
 * @package App\Models
 * @version December 28, 2021, 9:12 am +07
 *
 * @property string $merchant_id
 * @property string $request
 * @property string $response
 */
class CollectOnBehalf extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'collect_on_behalf';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'function',
        'merchant_id',
        'merchant_fee',
        'request',
        'requestID',
        'old_requestId',
        'response',
        'order_number',
        'ftType',
        'numberOfBeneficiary',
        'amount',
        'bankId',
        'transfer_id',
        'description',
        'nameOfBeneficiary',
        'refNum',
        'fee',
        'requestId',
        'code',
        'message',
        'current_balance',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'function' => 'string',
        'merchant_id' => 'string',
        'request' => 'string',
        'response' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'function' => 'required|string',
        'merchant_id' => 'required|string',
        'request' => 'required|string',
        'response' => 'required|string',
        'created_at' => 'required',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable',
        'description' => 'nullable|string|max:255'
    ];


}
