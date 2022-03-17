<?php

namespace App\Http\Controllers\_Backend;

use App\Http\Requests\CreateFeeConfigRequest;
use App\Http\Requests\UpdateFeeConfigRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\_Backend\FeeConfig;
use App\Models\_Backend\OperatorLog;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Response;

class FeeConfigController extends AppBaseController
{
    /**
     * Display a listing of the FeeConfig.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
     */
    public function index(Request $request)
    {
        updateFeeConfig();
        /** @var FeeConfig $feeConfigs */
        $feeConfigs = FeeConfig::withoutTrashed();
        $search = $request->post();
//        if (isset($search['type']) && $search['type'] != '') {
//            $feeConfigs->where(['type' => $search['type']]);
//        }
//        if (isset($search['merchant_id']) && $search['merchant_id'] != '') {
//            $feeConfigs->where(['merchant_id' => $search['merchant_id']]);
//        }
//        if (isset($search['status']) && $search['status'] != '') {
//            $feeConfigs->where(['status' => $search['status']]);
//        }
//        if ((isset($search['create_from']) && $search['create_from'] != '') || (isset($search['create_to']) && $search['create_to'] != '')) {
//            if (!isset($search['create_from'])) {
//                $search['create_from'] = '1970-01-01';
//            }
//            if (!isset($search['create_to'])) {
//                $search['create_to'] = '2100-12-31';
//            }
//            //$from = date('Y-m-d H:i:s', strtotime($search['create_from'] . ' 00:00:00'));
//            $from = date($search['create_from']. ' 00:00:00') ;
//            //$to = date('Y-m-d H:i:s', strtotime($search['create_to'] . ' 23:59:59'));
//            $to = date($search['create_to']. ' 23:59:59');
//            $feeConfigs->whereBetween('created_at', [$from, $to]);
//
//
//        }
        $feeConfigs=querySearch($search,$feeConfigs);

        $feeConfigs = $feeConfigs->orderBy('created_at', 'desc')->paginate(15)->appends($search);
        return view('_backend.fee_configs.index')
            ->with('feeConfigs', $feeConfigs);
    }

    /**
     * Show the form for creating a new FeeConfig.
     *
     * @return Response
     */
    public function create()
    {
        return view('_backend.fee_configs.create');
    }

    /**
     * Store a newly created FeeConfig in storage.
     *
     * @param CreateFeeConfigRequest $request
     *
     * @return Response
     */
    public function store(CreateFeeConfigRequest $request)
    {
        $input = $request->all();
        foreach ($input['amount_from'] as $key => $value) {
            $input['amount_from'][$key]=str_replace(',','',$input['amount_from'][$key]);
            $input['amount_to'][$key]=str_replace(',','',$input['amount_to'][$key]);
            $input['fee_data'][$key] = json_encode([
                "amount_from" => $input['amount_from'][$key],
                "amount_to" => $input['amount_to'][$key],
                "fixed_fee" => $input['fixed_fee'][$key],
                "percentage_fee" => $input['percentage_fee'][$key],
            ]);
        }
       $input['fee_data']=json_encode($input['fee_data']);
        $input['applied_from'] = date('Y-m-d H:i:s', strtotime($input['applied_from']));
        if (strtotime($input['applied_from']) > time()) {
            $input['status'] = 2;
        } else {
            $input['status'] = 0;
        }
        //$input['status'] = 0;
//        $oldFeeConfig = FeeConfig::withoutTrashed()->where(['merchant_id' => $input['merchant_id'],'type'=>$input['type']])->get();
//        if (count($oldFeeConfig) > 0) {
//            foreach ($oldFeeConfig as $item) {
//                $item->status = 1;
//                $item->save();
//            }
//        }
        /** @var FeeConfig $feeConfig */
        $feeConfig = FeeConfig::create($input);
        if ($feeConfig->type == 1) {
            $type = 'Thu hộ';
        } elseif ($feeConfig->type == 2) {
            $type = 'Chi hộ';
        } else {
            $type = '';
        }
        OperatorLog::create(['operator_id' => Auth::guard('backend')->id(), 'content' => 'Cấu hình phí ' . $type . ' cho Merchant ' . $feeConfig->merchant_id]);

        Flash::success('Cấu hình phí thành công cho merchant ' . $feeConfig->merchant_id);

        return redirect(route('feeConfigs.index'));
    }

    /**
     * Display the specified FeeConfig.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FeeConfig $feeConfig */
        $feeConfig = FeeConfig::find($id);

        if (empty($feeConfig)) {
            Flash::error('Fee Config not found');

            return redirect(route('feeConfigs.index'));
        }

        return view('_backend.fee_configs.show')->with('feeConfig', $feeConfig);
    }

    /**
     * Show the form for editing the specified FeeConfig.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var FeeConfig $feeConfig */
        $feeConfig = FeeConfig::find($id);

        if (empty($feeConfig)) {
            Flash::error('Fee Config not found');

            return redirect(route('feeConfigs.index'));
        }

        return view('_backend.fee_configs.edit')->with('feeConfig', $feeConfig);
    }

    /**
     * Update the specified FeeConfig in storage.
     *
     * @param int $id
     * @param UpdateFeeConfigRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFeeConfigRequest $request)
    {
        /** @var FeeConfig $feeConfig */
        $feeConfig = FeeConfig::find($id);

        if (empty($feeConfig)) {
            Flash::error('Fee Config not found');

            return redirect(route('feeConfigs.index'));
        }

        $feeConfig->fill($request->all());
        $feeConfig->save();

        Flash::success('Fee Config updated successfully.');

        return redirect(route('feeConfigs.index'));
    }

    /**
     * Remove the specified FeeConfig from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var FeeConfig $feeConfig */
        $feeConfig = FeeConfig::find($id);

        if (empty($feeConfig)) {
            Flash::error('Fee Config not found');

            return redirect(route('feeConfigs.index'));
        }

        $feeConfig->delete();

        Flash::success('Fee Config deleted successfully.');

        return redirect(route('feeConfigs.index'));
    }
}
