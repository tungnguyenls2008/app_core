<?php

namespace App\Repositories;

use App\Models\BalanceChangeTransfer;
use App\Repositories\BaseRepository;

/**
 * Class BalanceChangeRepository
 * @package App\Repositories
 * @version December 28, 2021, 4:27 pm +07
*/

class BalanceChangeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'function',
        'request',
        'current_balance',
        'merchant_id',
        'response'
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
        return BalanceChangeTransfer::class;
    }
}
