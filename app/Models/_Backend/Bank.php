<?php

namespace App\Models\_Backend;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Bank
 * @package App\Models
 * @version January 7, 2022, 5:02 pm +07
 *
 * @property integer $bank_id
 * @property string $bank_name
 */
class Bank extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'banks';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $connection = "backend";

    public $fillable = [
        'bank_id',
        'bank_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'bank_id' => 'integer',
        'bank_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
//        'bank_id' => 'required|integer',
//        'bank_name' => 'required|string|max:32',
//        'updated_at' => 'nullable',
//        'deleted_at' => 'nullable'
    ];


}
