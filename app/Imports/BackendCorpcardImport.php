<?php

namespace App\Imports;

use App\Models\CardIdToNumber;
use App\Models\CollectOnBehalf;
use App\Models\CorpCard;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Row;


class BackendCorpcardImport implements ToModel, WithHeadingRow,WithUpserts
{

    /**
     * @param array $row
     *
     * @return CardIdToNumber
     */
    public function model(array $row)
    {

        $check_cards = CardIdToNumber::withoutTrashed()->where(['card_id' => $row['card_id']])->orderBy('created_at', 'desc')->first();
        if ($check_cards != null) {
            return new CardIdToNumber(
                [
                    //'request_id' => $requestId,
                    'merchant_id' => $check_cards->merchant_id,
                    'card_id' => $row['card_id'],
                    'card_number' => $row['card_number'],
                    'issued_at' => $row['ngay_ph'],
                    'expired_at' => $row['expir_date'],
                    'cardholder_name' => $row['cardholder_name'],
                    'message' => $check_cards->message,
                ]
            );
        }else return null;

    }

    public function headingRow(): int
    {
        return 1;
    }

    public function uniqueBy()
    {
        return 'card_id';
    }
}
