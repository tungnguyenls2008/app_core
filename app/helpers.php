<?php

use App\Http\Controllers\API\CollectOnBehalfAPIController;
use App\Models\_Backend\FeeConfig;
use App\Models\_Backend\OperatorLog;
use App\Models\_Backend\SubMerchantBalance;
use App\Models\CollectOnBehalf;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

function idGenerator($num, $prefix)
{
    return $prefix . str_pad($num, 8, '0', STR_PAD_LEFT);
}

function generateRandomString($length = 8): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function arrayPaginate($items, $perPage = 5, $page = null, $options = [])
{
    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    $items = $items instanceof Collection ? $items : Collection::make($items);
    return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
}

function collectionPaginate($collection, $perPage, $pageName = 'page', $fragment = null)
{
    $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage($pageName);
    $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage);
    parse_str(request()->getQueryString(), $query);
    unset($query[$pageName]);
    $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
        $currentPageItems,
        $collection->count(),
        $perPage,
        $currentPage,
        [
            'pageName' => $pageName,
            'path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath(),
            'query' => $query,
            'fragment' => $fragment
        ]
    );

    return $paginator;
}

function listBanks()
{
    $default = \App\Models\_Backend\DefaultAppIdAndSecret::withoutTrashed()->where(['type' => 2])->first();
    if ($default != null) {

        $data = genData(['bankAppId' => $default->app_id]);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('EPG_BASE_URL') . 'openbanking/' . env('EPG_TOKEN') . '/banks',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response, true);
        if ($response != null) {
            return $response['data'];
        } else return 'Error no response';
    } else {
        return 'Error no AppID';
    }

}

function genSignature($input)
{
    $private_key = file_get_contents(storage_path('epg-private.key'));
    $public_key = file_get_contents(storage_path('epg-public.key'));
    $result = openssl_sign($input, $signature, $private_key, OPENSSL_ALGO_SHA256);
    if ($result) {
        $r = openssl_verify($input, $signature, $public_key, "sha256WithRSAEncryption");
        return base64_encode($signature);
    }
    return ('Error compute signature');
}

function genCallbackSignature($input)
{
    $private_key = file_get_contents(storage_path('callback-private.key'));
    $public_key = file_get_contents(storage_path('callback-public.key'));
    $result = openssl_sign($input, $signature, $private_key, OPENSSL_ALGO_SHA256);
    if ($result) {
        $r = openssl_verify($input, $signature, $public_key, "sha256WithRSAEncryption");
        return base64_encode($signature);
    }
    return ('Error compute signature');
}

function verifyCallbackToMerchantSignature($input, $signature)
{
    $public_key = file_get_contents(storage_path('callback-public.key'));

    $signature = base64_decode($signature);
    return openssl_verify($input, $signature, $public_key, 'sha256WithRSAEncryption');

}

function genData($input)
{
    $signature = genSignature(json_encode($input));
    $data['data'] = json_encode($input);
    $data['signature'] = $signature;
    $data['version'] = '1.1';
    return json_encode($data);
}

function log_action($content, $note)
{

    OperatorLog::create(['operator_id' => Auth::guard('backend')->id() ?? 0, 'content' => $content, 'function' => $note]);

}

function clearRouteCache()
{
    \Illuminate\Support\Facades\Artisan::call('route:cache');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
}

function updateFeeConfig()
{

    $feeConfigs_update = FeeConfig::withoutTrashed();
    $merchant_ids = FeeConfig::withoutTrashed()->select(['merchant_id'])->get();
    $merchant_ids_array = [];
    foreach ($merchant_ids as $merchant_id) {
        $merchant_ids_array[] = $merchant_id->merchant_id;
    }
    $merchant_ids_array = array_unique($merchant_ids_array);
    $merchant_ids_array = array_values($merchant_ids_array);


    $fee = $feeConfigs_update->whereIn('merchant_id', $merchant_ids_array)->get();
    foreach ($fee as $item) {
        if ($item->applied_from != null && $item->applied_from <= date('Y-m-d H:i:s', time())) {
            $item->status = 1;
        } else {
            $item->status = 2;
        }
        $item->save();

    }
    foreach ($merchant_ids_array as $item) {
        $active_fee_collect = FeeConfig::withoutTrashed()->where(['merchant_id' => $item])
            ->whereDate('applied_from', '<', date('Y-m-d H:i:s', time()))
            ->where(['type' => 1])
            ->orderBy('applied_from', 'desc')
            ->first();
        if ($active_fee_collect != null) {
            $active_fee_collect->status = 0;
            $active_fee_collect->save();
        }
        $active_fee_pay = FeeConfig::withoutTrashed()->where(['merchant_id' => $item])
            ->whereDate('applied_from', '<', date('Y-m-d H:i:s', time()))
            ->where(['type' => 2])
            ->orderBy('applied_from', 'desc')
            ->first();
        if ($active_fee_pay != null) {
            $active_fee_pay->status = 0;
            $active_fee_pay->save();
        }
    }


}

function setMerchantFee($fee_data, $input)
{
    $merchant_fee = 0;
    $fee_data = json_decode($fee_data, true);
    foreach ($fee_data as $key => $datum) {
        $fee_data[$key] = json_decode($datum, true);
        if ($fee_data[$key]['amount_from'] <= $input['amount'] && $input['amount'] <= $fee_data[$key]['amount_to']) {
            $merchant_fee = ($fee_data[$key]['fixed_fee'] ?? 0) + (($input['amount'] * ($fee_data[$key]['percentage_fee'] ?? 0)) / 100);
            break;
        }
    }
    return $merchant_fee;
}

function querySearch($search, $model)
{
    if (isset($search['ftType']) && $search['ftType'] != '') {
        $model->where(['ftType' => $search['ftType']]);
    }
    if (isset($search['merchant_id']) && $search['merchant_id'] != '') {

        if ($model->getModel()->table == 'operator_log') {
            $model->where('function', 'LIKE', '%' . $search['merchant_id'] . '%');
        } else {
            $model->where(['merchant_id' => $search['merchant_id']]);
        }
    }
    if (isset($search['numberOfBeneficiary']) && $search['numberOfBeneficiary'] != '') {
        $model->where(['numberOfBeneficiary' => $search['numberOfBeneficiary']]);
    }
    if (isset($search['refNum']) && $search['refNum'] != '') {
        $model->where(['refNum' => $search['refNum']]);
    }
    if (isset($search['order_number']) && $search['order_number'] != '') {
        $model->where(['order_number' => $search['order_number']]);
    }
    if (isset($search['requestId']) && $search['requestId'] != '') {
        //$model->where(['requestId' => $search['requestId']]);
        $model->where(function ($query) use ($search) {
            return $query->where(['requestId' => $search['requestId']])
                ->orWhere('old_requestId','like','%'.$search['requestId'].'%');
        });
    }
    if (isset($search['nameOfBeneficiary']) && $search['nameOfBeneficiary'] != '') {
        $model->where('nameOfBeneficiary', 'LIKE', '%' . $search['nameOfBeneficiary'] . '%');
    }
    if (isset($search['bank_id_search']) && $search['bank_id_search'] != '') {
        $model->where(['bankId' => $search['bank_id_search']]);
    }
    if (isset($search['description']) && $search['description'] != '') {
        $model->where('description', 'LIKE', '%' . $search['description'] . '%');
    }
    if (isset($search['status']) && $search['status'] != '') {
        if ($model->getModel()->table == 'operator_log') {
            $model->where('function', 'LIKE', '%' . $search['status'] . '%');
        } elseif ($model->getModel()->table == 'fee_config') {
            $model->where(['status' => $search['status']]);
        } else {
            if ($search['status'] == '999') {
                $model->where(function ($query) {
                    return $query->whereNotIn('code', ['1', '901', '300', '911'])
                        ->orWhereNull('code');
                });
                //$model->whereNotIn('code', ['1', '901', '300', '911']);
            } else {
                $model->where(['code' => $search['status']]);
            }
        }
    }
    if ((isset($search['updated_from']) && $search['updated_from'] != '') || (isset($search['updated_to']) && $search['updated_to'] != '')) {
        if (!isset($search['updated_from'])) {
            $search['updated_from'] = '1970-01-01';
        }
        if (!isset($search['updated_to'])) {
            $search['updated_to'] = '2100-12-31';
        }
        $from = date('Y-m-d H:i:s', strtotime($search['updated_from'] . ' 00:00:00'));
        $to = date('Y-m-d H:i:s', strtotime($search['updated_to'] . ' 23:59:59'));
        $model->whereBetween('updated_at', [$from, $to]);
    }
    if ((isset($search['tranDate_from']) && $search['tranDate_from'] != '') || (isset($search['tranDate_to']) && $search['tranDate_to'] != '')) {
        if (!isset($search['tranDate_from'])) {
            $search['tranDate_from'] = '1970-01-01';
        }
        if (!isset($search['tranDate_to'])) {
            $search['tranDate_to'] = '2100-12-31';
        }
        $tranDate = DB::raw("STR_TO_DATE(`tranDate`, '%Y-%m-%d')");
        $from = date('Y-m-d H:i:s', strtotime($search['tranDate_from'] . ' 00:00:00'));
        $to = date('Y-m-d H:i:s', strtotime($search['tranDate_to'] . ' 23:59:59'));
        $model->where($tranDate, "<=", $to)->where($tranDate, ">=", $from);
    }
    if ((isset($search['fee_from']) && $search['fee_from'] != '') || (isset($search['fee_to']) && $search['fee_to'] != '')) {

        if (!isset($search['fee_from'])) {
            $search['fee_from'] = 0;
        }
        if (!isset($search['fee_to'])) {
            $search['fee_to'] = 9999999999;
        }
        $model->whereBetween('merchant_fee', [$search['fee_from'], $search['fee_to']]);
    }
    if ((isset($search['amount_from']) && $search['amount_from'] != '') || (isset($search['amount_to']) && $search['amount_to'] != '')) {
        if (!isset($search['amount_from'])) {
            $search['amount_from'] = 0;
        }
        if (!isset($search['amount_to'])) {
            $search['amount_to'] = 9999999999;
        }
        $model->whereBetween('amount', [$search['amount_from'], $search['amount_to']]);
    }
    if (isset($search['card_id']) && $search['card_id'] != '') {
        $model->where(['card_id' => $search['card_id']]);
    }
    if (isset($search['request_id']) && $search['request_id'] != '') {
        $model->where(['request_id' => $search['request_id']]);
    }
    if (isset($search['card_status']) && $search['card_status'] != '') {
        if ($search['card_status'] == 1) {
            $model->where('merchant_id', '!=', null)->where('card_id', 'not like', 'FAILED-%');
        } elseif ($search['card_status'] == 2) {
            $model->where(['merchant_id' => null])->where('card_id', 'not like', 'FAILED-%');
        }
    }
    if (isset($search['card_number']) && $search['card_number'] != '') {
        $model->where(['card_number' => $search['card_number']]);
    }
    if (isset($search['cardholder_name']) && $search['cardholder_name'] != '') {
        $model->where('cardholder_name', 'LIKE', '%' . $search['cardholder_name'] . '%');
    }
    if ((isset($search['issued_from']) && $search['issued_from'] != '') || (isset($search['issued_to']) && $search['issued_to'] != '')) {
        if (!isset($search['issued_from'])) {
            $search['issued_from'] = '1970-01-01';
        }
        if (!isset($search['issued_to'])) {
            $search['issued_to'] = '2100-12-31';
        }
        $from = date('Y-m-d H:i:s', strtotime($search['issued_from'] . ' 00:00:00'));
        $to = date('Y-m-d H:i:s', strtotime($search['issued_to'] . ' 23:59:59'));
        $model->whereBetween('issued_at', [$from, $to]);
    }
    if ((isset($search['expired_from']) && $search['expired_from'] != '') || (isset($search['expired_to']) && $search['expired_to'] != '')) {
        if (!isset($search['expired_from'])) {
            $search['expired_from'] = '1970-01-01';
        }
        if (!isset($search['expired_to'])) {
            $search['expired_to'] = '2100-12-31';
        }
        $from = date('Y-m-d H:i:s', strtotime($search['expired_from'] . ' 00:00:00'));
        $to = date('Y-m-d H:i:s', strtotime($search['expired_to'] . ' 23:59:59'));
        $model->whereBetween('expired_at', [$from, $to]);
    }
    if (isset($search['type']) && $search['type'] != '') {
        $model->where(['type' => $search['type']]);
    }
    if (isset($search['name']) && $search['name'] != '') {
        $model->where('name', 'like', '%' . $search['name'] . '%');
    }
    if (isset($search['email']) && $search['email'] != '') {
        $model->where(['email' => $search['email']]);
    }
    if (isset($search['phone']) && $search['phone'] != '') {
        $model->where(['phone' => $search['phone']]);
    }
    if (isset($search['address']) && $search['address'] != '') {
        $model->where('address', 'like', '%' . $search['address'] . '%');
    }
    if (isset($search['website']) && $search['website'] != '') {
        $model->where(['website' => $search['website']]);
    }
    if (isset($search['default_card']) && $search['default_card'] != '') {
        $model->where(['default_card' => $search['default_card']]);
    }
    if (isset($search['content']) && $search['content'] != '') {
        $model->where('content', 'LIKE', '%' . $search['content'] . '%');
    }
    if (isset($search['operator_id']) && $search['operator_id'] != '') {
        $model->where(['operator_id' => $search['operator_id']]);
    }
    if (isset($search['ft_code']) && $search['ft_code'] != '') {
        $model->where('function', 'LIKE', '%' . $search['ft_code'] . '%');
    }
    if (isset($search['tranId']) && $search['tranId'] != '') {
        $model->where('tranId', 'LIKE', '%' . $search['tranId'] . '%');
    }
    if (isset($search['cardId']) && $search['cardId'] != '') {
        $model->where(['cardId' => $search['cardId']]);
    }
    if (isset($search['account_number']) && $search['account_number'] != '') {
        $model->where(['account' => $search['account_number']]);
    }
    if (isset($search['id']) && $search['id'] != '') {
        $model->where(['callback_id' => $search['id']]);
    }
    if ((isset($search['create_from']) && $search['create_from'] != '') || (isset($search['create_to']) && $search['create_to'] != '')) {
        if (!isset($search['create_from'])) {
            $search['create_from'] = '1970-01-01';
        }
        if (!isset($search['create_to'])) {
            $search['create_to'] = '2100-12-31';
        }
        $from = date('Y-m-d H:i:s', strtotime($search['create_from'] . ' 00:00:00'));
        $to = date('Y-m-d H:i:s', strtotime($search['create_to'] . ' 23:59:59'));
        $model->whereBetween('created_at', [$from, $to]);
    }
    if ((isset($search['applied_from']) && $search['applied_from'] != '') || (isset($search['applied_to']) && $search['applied_to'] != '')) {
        if (!isset($search['applied_from'])) {
            $search['applied_from'] = '1970-01-01';
        }
        if (!isset($search['applied_to'])) {
            $search['applied_to'] = '2100-12-31';
        }
        $from = date('Y-m-d H:i:s', strtotime($search['applied_from'] . ' 00:00:00'));
        $to = date('Y-m-d H:i:s', strtotime($search['applied_to'] . ' 23:59:59'));
        $model->whereBetween('applied_from', [$from, $to]);
    }
    if (isset($search['transfer_id']) && $search['transfer_id'] != '') {
        $model->where(['transfer_id' => $search['transfer_id']]);
    }
    if (isset($search['card_id ']) && $search['card_id '] != '') {
        $model->where(['card_id ' => $search['card_id ']]);
    }

    if (isset($search['bank_id']) && $search['bank_id'] != '') {
        $model->where(['bank_id' => $search['bank_id']]);
    }
    if (isset($search['bank_name']) && $search['bank_name'] != '') {
        $model->where('bank_name', 'like', '%' . $search['bank_name'] . '%');
    }
    return $model;
}

function array_in_string($str, array $arr): bool
{
    foreach ($arr as $arr_value) { //start looping the array
        if (stripos($str, $arr_value) !== false) return true; //if $arr_value is found in $str return true
    }
    return false; //else return false
}

function array_flatten($array)
{
    if (!is_array($array)) {
        return FALSE;
    }
    $result = array();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $result = array_merge($result, array_flatten($value));
        } else {
            $result[$key] = $value;
        }
    }
    return $result;
}

function getRoutesByGroup(array $group = [])
{
    $list = Route::getRoutes()->getRoutesByName();
    if (empty($group)) {
        return $list;
    }

    $routes = [];
    foreach ($list as $route) {
        $action = $route->getAction();
        foreach ($group as $key => $value) {
            if (empty($action[$key])) {
                continue;
            }
            $actionValues = Arr::wrap($action[$key]);
            $values = Arr::wrap($value);
            foreach ($values as $single) {
                foreach ($actionValues as $actionValue) {
                    if (Str::is($single, $actionValue)) {
                        $routes[] = $route->getName();
                    } elseif ($actionValue == $single) {
                        $routes[] = $route->getName();
                    }
                }
            }
        }
    }

    return $routes;
}

function getBackendRouteList()
{

    $routeCollection = getRoutesByGroup(['middleware' => 'auth:backend']);
    $exceptions = [

        'roles',
        'login',
        'logout',
        //'register',

        'backend-verification',
        'backend-password.',
        'merchant-password.email',
        //'ajax-get-account',

        'users.',

    ];
    $roles = \App\Models\_Backend\Role::withoutTrashed()->select('route')->get();
    $registered_route = [];
    foreach ($roles as $role) {
        $registered_route[] = json_decode($role->route, true);
    }
    $registered_route = array_flatten($registered_route);
    array_push($exceptions, array_values($registered_route));
    $exceptions = array_flatten($exceptions);
    foreach ($routeCollection as $key => $route) {
        if (array_in_string($route, $exceptions)) {
            unset($routeCollection[$key]);
        }
    }
    $routeCollection = array_values($routeCollection);
    $routeCollectionText = [];
    foreach ($routeCollection as $item) {
        $routeCollectionText[] = mappingRouteName($item);
    }

    return array_combine($routeCollection, $routeCollectionText);

}

function checkOperatorPermission($route_name)
{
    if (Auth::guard('backend')->user()->is_superadmin == 0) {

        $permissions = Auth::guard('backend')->user()->permissions;
        $permissions = json_decode($permissions, true);
        $roles = \App\Models\_Backend\Role::withoutTrashed()->whereIn('id', $permissions)->get();
        $accepted_routes = [];
        foreach ($roles as $role) {
            $accepted_routes[] = json_decode($role->route);
        }
        $accepted_routes = array_flatten($accepted_routes);
        if (in_array($route_name, $accepted_routes)) {
            return true;
        }
    } else return true;
}

function getBackendRouteListEdit()
{

    $routeCollection = getRoutesByGroup(['middleware' => 'auth:backend']);
    $exceptions = [

        'roles',
        'login',
        'logout',
        //'register',

        'backend-verification',
        'backend-password.',
        'merchant-password.email',
        //'ajax-get-account',

        'users.',

    ];

    foreach ($routeCollection as $key => $route) {
        if (array_in_string($route, $exceptions)) {
            unset($routeCollection[$key]);
        }
    }
    $routeCollection = array_values($routeCollection);
    $routeCollectionText = [];
    foreach ($routeCollection as $item) {
        $routeCollectionText[] = mappingRouteName($item);
    }
    return array_combine($routeCollection, $routeCollectionText);

}

function mappingRouteName($routes)
{
    return str_replace(
        [
            "backend-home", "backend-create-corpcard", "backend-mass-create-corpcard-view", "backend-mass-create-corpcard",
            "multi-corpcard-set-merchant", "corpcard-set-merchant", "backend-corpcard-import-by-hand", "backend-corpcard-import",
            "backend-corpcard-export", "sub-merchant-change-default-card", "merchant-change-default-card",
            "sub-merchant-toggle-lock", "merchant-toggle-lock", "sub-merchant-increase-balance", "sub-merchant-decrease-balance",
            "sub-merchant-set-transfer-limit", "backend-get-banks", "backend-balanceChange-callback-search", "backend-balanceChange-callback-search-sub-merchant",
            "backend-balanceChange-transfer-search-sub-merchant", "backend-balanceChange-transfer-search", "backend-callback-export",
            "backend-callback-sub-merchant-export", "backend-transfer-export", "backend-transfer-sub-merchant-export", "default-bank-info",
            "recheck-transaction-backend", "manual-update-transaction", "sub-merchants.index", "sub-merchants.create", "merchants.index", "merchants.create",
            "backend-balanceChangeTransfers.index", "backend-balanceChangeTransfers-sub-merchant.index", "backend-balanceChangeCallbacks.index",
            "backend-balanceChangeCallbacks-sub-merchant.index", "backend-corpCards.index", "feeConfigs.index", "feeConfigs.create", "feeConfigs.store",
            "banks.index", "banks.store", "backend-merchantBankAccounts.index", "subMerchantBalances.index", "operatorLogs.index", "topupHistory.index",
            "home", "corpcard-import-view", "callback-export", "transfer-export", "get-banks", "corpcard-import", "corpcard-export", "update-profile",
            "balanceChange-callback-search", "balanceChange-transfer-search", "corpcard-search", "corpcard-create", "balanceChangeTransfers.index",
            "balanceChangeCallbacks.index", "corpCards.index", 'backend-password-change', 'sub-merchant-password.reset', 'sub-merchant-password.update',
            'merchant-password.reset', 'merchant-password.update', 'ajax-get-account', 'backend-sub-merchant-balance-export', 'backend-operator-log-export',
            'backend-topup-history-export', 'sub-merchant-register-view', 'sub-merchant-register', 'merchant-register-view', 'merchant-register',
            'backend-callback-not-merchant-export','backend-balanceChangeCallbacks-not-merchant.index',
            're-transfer-backend','captcha-validation','reload-captcha'

        ],
        [
            "Xem trang chủ", "Tạo thẻ ảo", "Giao diện tạo nhiều thẻ ảo", "Tạo nhiều thẻ ảo",
            "Gán nhiều thẻ ảo cho merchant", "Gán thẻ ảo cho merchant", "Cập nhật danh sách thẻ ảo thủ công", "Cập nhật danh sách thẻ ảo",
            "Xuất danh sách CardID", "Đổi thẻ mặc định HQPAY merchant(topup)", "Đổi thẻ mặc định(topup)",
            "Khóa/mở khóa HQPAY merchant", "Khóa/mở khóa Merchant", "Tăng số dư HQPAY merchant", "Giảm số dư HQPAY merchant",
            "Đặt hạn mức chi cho HQPAY merchant", "Cập nhật danh sách ngân hàng", "Tìm kiếm giao dịch thu hộ", "Tìm kiếm giao dịch thu hộ HQPAY merchant",
            "Tìm kiếm giao dịch chi hộ HQPAY merchant", "Tìm kiếm giao dịch chi hộ", "Xuất Excel giao dịch thu hộ",
            "Xuất Excel giao dịch thu hộ HQPAY merchant", "Xuất Excel giao dịch chi hộ", "Xuất Excel giao dịch chi hộ HQPAY merchant", "Cài đặt mặc định AppID&Secret HQPAY merchant",
            "Kiểm tra giao dịch chi hộ", "Cập nhật thủ công giao dịch chi hộ", "Danh sách HQPAY merchant", "Đăng ký HQPAY merchant mới(link)", "Danh sách merchant", "Đăng ký merchant mới(link)",
            "Danh sách giao dịch chi hộ", "Danh sách giao dịch chi hộ HQPAY merchant", "Danh sách giao dịch thu hộ",
            "Danh sách giao dịch thu hộ HQPAY merchant", "Danh sách thẻ ảo", "Danh sách cấu hình phí", "Tạo mới cấu hình phí(Giao diện)", "Tạo mới cấu hình phí",
            "Danh sách ngân hàng", "Cập nhật danh sách ngân hàng", "Danh sách tài khoản thu", "Danh sách biến động số dư", "Danh sách lịch sử vận hành", "Danh sách lịch sử Topup",
            "Trang chủ(giao diện merchant)", "Cập nhật thẻ ảo(giao diện merchant)", "Xuất Excel thu hộ(giao diện merchant)", "Xuất Excel chi hộ(giao diện merchant)", "lấy danh sách ngân hàng(giao diện merchant)", "Cập nhật thẻ ảo(giao diện merchant)", "Xuất Excel CardID(giao diện merchant)", "Cập nhật thông tin(giao diện merchant)",
            "Tìm kiếm giao dịch thu hộ(giao diện merchant)", "Tìm kiếm giao dịch chi hộ(giao diện merchant)", "Tìm kiếm thẻ ảo(giao diện merchant)", "Tạo thẻ ảo(giao diện merchant)", "Danh sách giao dịch chi hộ(giao diện merchant)",
            "Danh sách giao dịch thu hộ(giao diện merchant)", "Danh sách thẻ ảo(giao diện merchant)", 'Đổi mật khẩu tài khoản Vận hành viên', 'Thiết lập lại mật khẩu HQPAY merchant(giao diện)', 'Thiết lập lại mật khẩu HQPAY merchant',
            'Thiết lập lại mật khẩu merchant(giao diện)', 'Thiết lập lại mật khẩu merchant', 'Truy xuất tài khoản HQPAY', 'Xuất Excel biến động số dư HQPAY merchant', 'Xuất Excel lịch sử vận hành',
            'Xuất Excel lịch sử Topup', 'Đăng ký HQPAY merchant mới(giao diện)', 'Đăng ký HQPAY merchant mới', 'Đăng ký merchant mới(giao diện)', 'Đăng ký merchant mới',
            'Xuất Excel giao dịch thu ngoài','Danh sách giao dịch thu ngoài',
            'Chi lại','Xác thực Captcha','Thay đổi Captcha'

        ],
        $routes);
}

function manualInquiryAndTransfer(CollectOnBehalf $transaction)
{
    $merchant = \App\Models\Merchant::withoutTrashed()->where(['merchant_id' => $transaction->merchant_id])->first();
    if ($merchant != null) {
        $input = [
            "ftType" => $transaction->ftType,
            "numberOfBeneficiary" => $transaction->numberOfBeneficiary,
            "amount" => $transaction->amount,
            "bankId" => $transaction->bankId,
            "description" => $transaction->description,
            'bankAppId' => $merchant->app_id_addition
        ];

        $curl = curl_init();
        $data = (genData($input));

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('EPG_BASE_URL') . 'openbanking/' . env('EPG_TOKEN') . '/inquiry',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response, true);

        //end inquiry
        //=============================
        //do transfer
        if (isset($response['data'])) {
            $response = json_decode($response['data'], true);
            $input['requestId'] = 'TF' . generateRandomString();

            if (isset($response['ok']) && $response['ok'] == true) {
                $input['nameOfBeneficiary'] = $response['nameOfBeneficiary'];
                $data = (genData($input));

                $to_save['function'] = $data;
                $to_save['request'] = json_encode($input);
                $to_save['requestId'] = $input['requestId'];
                $to_save['old_requestId']=$transaction->old_requestId.' '.$transaction->requestId;
                //$to_save['code'] = 777;//new transaction
                $transaction->update($to_save);
//                $check_ongoing_transfer = CollectOnBehalf::withoutTrashed()->where([
//                    //'merchant_id' => $merchant->merchant_id,
//                    'code' => 777])->count();
//                if ($check_ongoing_transfer > 0) {
//                    sleep($check_ongoing_transfer * 3);
//                }
//                //merchant fee below
//                updateFeeConfig();
//                $feeConfig = FeeConfig::withoutTrashed()->where(['merchant_id' => $merchant->merchant_id, 'status' => 0, 'type' => 2])
//                    //->whereDate('applied_from','<',date('Y-m-d H:i:s',time()))
//                    ->first();
//                if ($feeConfig != null) {
//                    $to_update['merchant_fee'] = setMerchantFee($feeConfig->fee_data, $input);
//                } else {
//                    $to_update['code'] = 301;
//                    $transaction->update($to_update);
//                    return [
//                        'success' => false,
//                        'code' => $to_update['code'],
//                        'requestId' => $input['requestId'],
//                        'message'=>'Chưa cấu hình phí.'
//                    ];
//                }
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => env('EPG_BASE_URL') . 'openbanking/' . env('EPG_TOKEN') . '/transfer',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $data,
                    CURLOPT_HTTPHEADER => array(
                        'Accept: application/json',
                        'Content-Type: application/json'
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                $to_update['response'] = $response;
                $response = json_decode($response, true);
                if (isset($response['data'])) {
                    $response = json_decode($response['data'], true);
                    $to_update['code'] = $response['code'];
                    $to_update['message'] = $response['message'] ?? '';
                    $to_update['transfer_id'] = $response['id']??'';
                    $to_update['refNum'] = $response['refNum']??'';
                    $to_update['fee'] = $response['fee']??0;
                    $to_update['nameOfBeneficiary'] = $response['nameOfBeneficiary']??'';
                    $to_update['updated_at'] = time();

                    $transaction->update($to_update);
                    if ($response['code']==1){
                        $message='Thành công';
                    }elseif($response['code']==901){
                        $message='Đang xử lý';
                    }else{
                        $message='Có lỗi khi chi lại';
                    }
                    $result = [
                        'success' => true,
                        'code' => $response['code'],
                        'requestId' => $input['requestId'],
                        'refNum' => $response['refNum'],
                        'fee' => number_format($response['fee']).' đ',
                        //'merchant_fee' => number_format($to_update['merchant_fee']).' đ',
                        'message'=>$message
                    ];


                } elseif ($response == null) {
                    $to_update['code'] = 901;
                    $to_update['message'] = 'Không có phản hồi từ nhà cung cấp dịch vụ.';
                    $to_update['updated_at'] = time();
                    $transaction->update($to_update);
                    $result = [
                        'success' => true,
                        'code' => $response['code'],
                        'requestId' => $input['requestId'],
                        'refNum' => $response['refNum'],
                        'fee' => number_format($response['fee']??0),
                        //'merchant_fee' => number_format($to_update['merchant_fee']),
                        'message'=>$to_update['message']
                    ];


                } else {
                    $to_update['code'] = 911;
                    //$to_update['merchant_fee'] = 0;
                    $to_update['message'] = 'Quá thời gian thực thi.';
                    $to_update['updated_at'] = time();
                    $transaction->update($to_update);
                    $result = [
                        'success' => false,
                        'code' => $to_update['code'],
                        'requestId' => $input['requestId'],
                        'message'=>$to_update['message']
                    ];
                }
            } else {
                $result = [
                    'success' => false,
                    'code' => $response['code'],
                    'requestId' => $input['requestId'],
                    'message'=>$response['message']
                ];
            }
        } elseif ($response == null) {
            $result = [
                'success' => false,
                'requestId' => $transaction->requestID,
                'message'=>'Không có phản hồi từ nhà cung cấp dịch vụ.'
            ];

        } else {
            $result = [
                'success' => false,
                'requestId' => $input['requestId'],
                'message'=>'Lỗi không xác định'
            ];
        }

    }else{
        $result = [
            'success' => false,
            'message'=>'Không tìm thấy Merchant này trên hệ thống'
        ];
    }
    return $result;
}
