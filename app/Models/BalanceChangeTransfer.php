<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class BalanceChange
 * @package App\Models
 * @version December 28, 2021, 4:27 pm +07
 *
 * @property string $function
 * @property string $request
 * @property string $response
 */
class BalanceChangeTransfer extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'collect_on_behalf';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'function',
        'request',
        'requestId',
        'description',
        'amount',
        'code',
        'merchant_id',
        'current_balance',
        'response',
        'updated_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'function' => 'string',
        'request' => 'string',
        'response' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'function' => 'required|string|max:255',
        'request' => 'required|string',
        'response' => 'required|string',
        'created_at' => 'required',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];


}
