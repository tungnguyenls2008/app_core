<?php

namespace App\Repositories;

use App\Models\BalanceChangeCallback;
use App\Repositories\BaseRepository;

/**
 * Class BalanceChangeCallbackRepository
 * @package App\Repositories
 * @version December 29, 2021, 9:08 am +07
*/

class BalanceChangeCallbackRepository extends BaseRepository
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
        'callback_id',
        'fee',
        'description',
        'cardId',
        'current_balance',
        'merchant_id',
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
        return BalanceChangeCallback::class;
    }
}
