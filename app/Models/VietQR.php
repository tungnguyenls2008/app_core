<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class VietQR
 * @package App\Models
 * @version January 13, 2022, 4:46 pm +07
 *
 * @property string $ftType
 * @property integer $amount
 * @property string $numberOfBeneficiary
 * @property string $description
 * @property string $qr_code
 * @property string $merchant_id
 */
class VietQR extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'vietqr_code';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'ftType',
        'amount',
        'numberOfBeneficiary',
        'description',
        'qr_code',
        'merchant_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'ftType' => 'string',
        'amount' => 'integer',
        'numberOfBeneficiary' => 'string',
        'description' => 'string',
        'qr_code' => 'string',
        'merchant_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'ftType' => 'required|string|max:12',
        'amount' => 'required|integer',
        'numberOfBeneficiary' => 'required|string|max:24',
        'description' => 'required|string|max:500',
        'qr_code' => 'nullable|string|max:500',
        'merchant_id' => 'required|string|max:12',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];


}
