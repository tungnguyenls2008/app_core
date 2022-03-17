<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Merchant
 * @package App\Models
 * @version December 29, 2021, 9:54 am +07
 *
 * @property string $name
 * @property string $email
 * @property string|\Carbon\Carbon $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property string $merchant_id
 * @property string $phone
 * @property string $address
 * @property string $website
 * @property string $logo
 * @property string $app_id
 * @property string $secret
 * @property string $app_id_addition
 * @property string $secret_addition
 * @property string $is_sub_merchant
 * @property string $bank_account
 * @property string $bank_id
 */
class Merchant extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'users';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'merchant_id',
        'phone',
        'address',
        'logo',
        'website',
        'callback_url',
        'app_id',
        'secret',
        'app_id_addition',
        'secret_addition',
        'is_sub_merchant',
        'default_card',
        'bank_account',
        'bank_id',
        'transfer_min',
        'transfer_max',
        're_transferable',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'password' => 'string',
        'remember_token' => 'string',
        'merchant_id' => 'string',
        'phone' => 'string',
        'address' => 'string',
        'logo' => 'string',
        'website' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|max:255',
        'email_verified_at' => 'nullable',
        'password' => 'required|string|max:255',
        'remember_token' => 'nullable|string|max:100',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'merchant_id' => 'nullable|string|max:24',
        'phone' => 'nullable|string|max:16',
        'logo' => 'nullable|string|max:500',
        'address' => 'nullable|string|max:255',
        'website' => 'nullable|string|max:64',
        'app_id' => 'nullable|unique:users|string|max:8',
        'secret' => 'nullable|unique:users|string|max:32',
        'bank_account' => 'nullable|string|max:32',
        'bank_id' => 'nullable|integer|max:32',
    ];


}
