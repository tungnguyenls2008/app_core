<?php

namespace App\Repositories;

use App\Models\Merchant;
use App\Repositories\BaseRepository;

/**
 * Class MerchantRepository
 * @package App\Repositories
 * @version December 29, 2021, 9:54 am +07
*/

class MerchantRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'merchant_id',
        'phone',
        'app_id',
        'secret',
        'app_id_addition',
        'secret_addition',
        'address',
        'is_sub_merchant',
        'website'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Merchant::class;
    }
}
