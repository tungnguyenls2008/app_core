<?php

namespace App\Repositories;

use App\Models\CollectOnBehalf;
use App\Repositories\BaseRepository;

/**
 * Class CollectOnBehalfRepository
 * @package App\Repositories
 * @version December 28, 2021, 9:12 am +07
*/

class CollectOnBehalfRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'function',
        'merchant_id',
        'merchant_fee',
        'request',
        'response',
        'ftType',
        'numberOfBeneficiary',
        'amount',
        'bankId',
        'transfer_id',
        'order_number',
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
        return CollectOnBehalf::class;
    }
}
