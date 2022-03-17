<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class EpgCallback
 * @package App\Models
 * @version December 27, 2021, 9:49 am +07
 *
 * @property string $request
 * @property string $response
 */
class EpgCallback extends Model
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
        'numberOfBeneficiary',
        'account',
        'internal_message',
        'callback_id',
        'merchant_id',
        'type',
        'fee',
        'merchant_fee',
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
