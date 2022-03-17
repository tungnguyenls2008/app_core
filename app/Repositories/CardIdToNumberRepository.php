<?php

namespace App\Repositories;

use App\Models\CardIdToNumber;
use App\Repositories\BaseRepository;

/**
 * Class CardIdToNumberRepository
 * @package App\Repositories
 * @version December 29, 2021, 5:19 pm +07
*/

class CardIdToNumberRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'request_id',
        'merchant_id',
        'card_id',
        'card_number',
        'issued_at',
        'expired_at',
        'cardholder_name',
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
        return CardIdToNumber::class;
    }
}
