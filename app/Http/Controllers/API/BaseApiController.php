<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;

class BaseApiController extends AppBaseController
{

    public function checkEmptyInput($input)
    {
        $empty_input = array();
        foreach ($input as $key => $item) {
            if ($item == null || $item == '') {
                array_push($empty_input, $key);
            }
        }
        return $empty_input;

    }

}
