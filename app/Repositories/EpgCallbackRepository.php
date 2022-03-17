<?php

namespace App\Repositories;

use App\Models\EpgCallback;
use App\Repositories\BaseRepository;

/**
 * Class EpgCallbackRepository
 * @package App\Repositories
 * @version December 27, 2021, 9:49 am +07
*/

class EpgCallbackRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'request',
        'response',
        'amount',
        'tranDate',
        'tranId',
        'type',
        'numberOfBeneficiary',
        'account',
        'internal_message',
        'callback_id',
        'merchant_id',
        'fee',
        'merchant_fee',
        'current_balance',
        'description',
        'cardId'
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
        return EpgCallback::class;
    }
}
