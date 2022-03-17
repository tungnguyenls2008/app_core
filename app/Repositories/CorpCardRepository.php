<?php

namespace App\Repositories;

use App\Models\CorpCard;
use App\Repositories\BaseRepository;

/**
 * Class CorpCardRepository
 * @package App\Repositories
 * @version December 29, 2021, 9:19 am +07
*/

class CorpCardRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'function',
        'merchant_id',
        'request',
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
        return CorpCard::class;
    }
}
