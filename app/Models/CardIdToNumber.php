<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class CardIdToNumber
 * @package App\Models
 * @version December 29, 2021, 5:19 pm +07
 *
 * @property string $merchant_id
 * @property string $card_id
 * @property string $card_number
 */
class CardIdToNumber extends Model
{
    use SoftDeletes;

    use HasFactory;


    public $table = 'card_id_to_number';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'request_id',
        'merchant_id',
        'card_id',
        'card_number',
        'issued_at',
        'expired_at',
        'cardholder_name',
        'message',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'merchant_id' => 'string',
        'card_id' => 'string',
        'card_number' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'request_id' => 'required|string|max:16',
        'merchant_id' => 'required|string|max:10',
        'card_id' => 'required|string|max:24',
        'card_number' => 'required|string|max:24',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];


}
