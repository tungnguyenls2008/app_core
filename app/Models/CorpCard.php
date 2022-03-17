<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class CorpCard
 * @package App\Models
 * @version December 29, 2021, 9:19 am +07
 *
 * @property string $function
 * @property string $merchant_id
 * @property string $request
 * @property string $response
 */
class CorpCard extends Model
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
        'request',
        'response'
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
        'function' => 'required|string|max:255',
        'merchant_id' => 'required|string|max:10',
        'request' => 'required|string',
        'response' => 'required|string',
        'created_at' => 'required',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];


}
