<?php

namespace App\Http\Controllers\_Backend;

use App\Http\Requests\CreateMerchantRequest;
use App\Http\Requests\UpdateMerchantRequest;
use App\Models\_Backend\OperatorLog;
use App\Models\_Backend\SubMerchantBalance;
use App\Models\BalanceChangeCallback;
use App\Models\BalanceChangeTransfer;
use App\Models\Merchant;
use App\Repositories\MerchantRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Response;

class SubMerchantController extends AppBaseController
{
    /** @var  MerchantRepository */
    private $merchantRepository;

    public function __construct(MerchantRepository $merchantRepo)
    {
        $this->merchantRepository = $merchantRepo;
    }

    /**
     * Display a listing of the Merchant.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $merchants = $this->merchantRepository->model()::where(['is_sub_merchant' => 1]);
        $search = $request->post();

        $merchants=querySearch($search,$merchants);
        $merchants = $merchants->paginate(15)->appends($search);
        return view('_backend.sub_merchants.index')
            ->with('merchants', $merchants);
    }

    /**
     * Show the form for creating a new Merchant.
     *
     * @return Response
     */
    public function create()
    {
        return view('_backend.sub_merchants.create');
    }

    /**
     * Store a newly created Merchant in storage.
     *
     * @param CreateMerchantRequest $request
     *
     * @return Response
     */
    public function store(CreateMerchantRequest $request)
    {
        $input = $request->all();

        $merchant = $this->merchantRepository->create($input);

        Flash::success(__('messages.saved', ['model' => __('models/merchants.singular')]));

        return redirect(route('sub_merchants.index'));
    }

    /**
     * Display the specified Merchant.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $merchant = $this->merchantRepository->find($id);

        if (empty($merchant)) {
            Flash::error(__('messages.not_found', ['model' => __('models/merchants.singular')]));

            return redirect(route('sub_merchants.index'));
        }

        return view('_backend.sub_merchants.show')->with('merchant', $merchant);
    }

    /**
     * Show the form for editing the specified Merchant.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $merchant = $this->merchantRepository->find($id);

        if (empty($merchant)) {
            Flash::error(__('messages.not_found', ['model' => __('models/merchants.singular')]));

            return redirect(route('merchants.index'));
        }

        return view('_backend.merchants.edit')->with('merchant', $merchant);
    }

    /**
     * Update the specified Merchant in storage.
     *
     * @param int $id
     * @param UpdateMerchantRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMerchantRequest $request)
    {
        $merchant = $this->merchantRepository->find($id);

        if (empty($merchant)) {
            Flash::error(__('messages.not_found', ['model' => __('models/merchants.singular')]));

            return redirect(route('merchants.index'));
        }

        $merchant = $this->merchantRepository->update($request->all(), $id);

        Flash::success(__('messages.updated', ['model' => __('models/merchants.singular')]));

        return redirect(route('merchants.index'));
    }

    /**
     * Remove the specified Merchant from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $merchant = $this->merchantRepository->find($id);

        if (empty($merchant)) {
            Flash::error(__('messages.not_found', ['model' => __('models/merchants.singular')]));

            return redirect(route('merchants.index'));
        }

        $this->merchantRepository->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/merchants.singular')]));

        return redirect(route('merchants.index'));
    }

    public function changeDefaultCard(Request $request)
    {
        $card = $request->all()['default_card'];
        $merchant = Merchant::withoutTrashed()->find($request->all()['merchant_id']);
        if ($merchant != null) {
            $merchant->default_card = $card;
            $merchant->save();
            OperatorLog::create(['operator_id' => Auth::guard('backend')->id(), 'content' => '?????i th??? m???c ?????nh cho HQPAY Merchant ' . $merchant->merchant_id]);

            Flash::success('Thay ?????i th??? m???c ?????nh th??nh c??ng cho merchant ' . $merchant->merchant_id);
        } else {
            Flash::error('Kh??ng t??m th???y Merchant.');
        }
        return redirect(route('sub-merchants.index'));
    }

    public function increaseBalance(Request $request)
    {
        $request = $request->all();
        $request['amount'] = (int)str_replace([',', '??'], '', $request['amount']);
        $check_ft_code=BalanceChangeCallback::withoutTrashed()->where(['tranId'=>$request['ft_code']])->count();
        if ($check_ft_code>0){
            Flash::error('M?? giao d???ch '.$request['ft_code'].' ???? t???n t???i');
            return back();
        }
        $balance = SubMerchantBalance::withoutTrashed()->where(['merchant_id' => $request['merchant_id']])->first();
        if ($balance != null) {
            $balance->amount = $balance->amount + $request['amount'];
            $balance->ft_code = $request['ft_code'];
            $balance->save();
            BalanceChangeCallback::create([
                'function'=>'{}',
                'request'=>'{}',
                'response'=>'{}',
                'amount'=>$request['amount'],
                'merchant_fee'=>0,
                'tranId'=>$request['ft_code'],
                'description'=>'TOPUP',
                'merchant_id'=>$request['merchant_id'],
                'current_balance'=>$balance->amount]);
            Flash::success('S??? d?? hi???n c?? c???a Merchant ' . $request['merchant_id'] . ' ???? ???????c t??ng l??n ' . number_format($request['amount']) . '??.');

            OperatorLog::create([
                'operator_id' => Auth::guard('backend')->id(), 'content' => 'T??ng s??? d?? hi???n c?? c???a HQPAY Merchant '
                    . $request['merchant_id']
                    . ' th??m ' . number_format($request['amount']) . '??, m?? ?????i chi???u: ' . $request['ft_code']
                    . ', s??? d?? hi???n c??: ' . number_format($balance->amount),
                'function' => json_encode(
                    [
                        'merchant_id' => $request['merchant_id'],
                        'amount' => $request['amount'],
                        'ft_code' => $request['ft_code'],
                        'status' => 'increase',
                        'balance' => $balance->amount
                    ])
            ]);
        } else {
            $merchant = Merchant::withoutTrashed()->where(['merchant_id' => $request['merchant_id']])->first();
            if ($merchant != null) {
                $balance = SubMerchantBalance::create($request);
                BalanceChangeCallback::create([
                    'function'=>'{}',
                    'request'=>'{}',
                    'response'=>'{}',
                    'amount'=>$request['amount'],
                    'merchant_fee'=>0,
                    'tranId'=>$request['ft_code'],
                    'description'=>'TOPUP',
                    'merchant_id'=>$request['merchant_id'],
                    'current_balance'=>$request['amount']]);
                OperatorLog::create(
                    [
                        'operator_id' => Auth::guard('backend')->id(),
                        'content' => 'T??ng s??? d?? hi???n c?? c???a HQPAY Merchant ' . $request['merchant_id'] . ' th??m ' . number_format($request['amount']) . '??., m?? ?????i chi???u: ' . $request['ft_code'],
                        'function' => json_encode(
                            [
                                'merchant_id' => $request['merchant_id'],
                                'amount' => $request['amount'],
                                'ft_code' => $request['ft_code'],
                                'status' => 'increase',
                                'balance' => $request['amount']
                            ])
                    ]);

                Flash::success('S??? d?? hi???n c?? c???a Merchant ' . $request['merchant_id'] . ' ???? ???????c t??ng l??n ' . number_format($request['amount']) . '??.');

            } else {
                Flash::error('Kh??ng t??m th???y Merchant.');
            }

        }
        return redirect(route('sub-merchants.index'));
    }

    public function decreaseBalance(Request $request)
    {
        $request = $request->all();
        $request['amount'] = (int)str_replace([',', '??'], '', $request['amount']);
        $balance = SubMerchantBalance::withoutTrashed()->where(['merchant_id' => $request['merchant_id']])->first();
        if ($balance != null) {
            if ($balance->amount >= $request['amount']) {
                $balance->amount = $balance->amount - $request['amount'];
                $balance->ft_code = $request['ft_code'];
                $balance->save();
                BalanceChangeTransfer::create([
                    'function'=>'{}',
                    'request'=>'{}',
                    'code'=>'1',
                    'amount'=>$request['amount'],
                    'requestId'=>$request['ft_code'],
                    'description'=>'Operator decrease',
                    'merchant_id'=>$request['merchant_id'],
                    'current_balance'=>$balance->amount]);
                Flash::success('S??? d?? hi???n c?? c???a Merchant ' . $request['merchant_id'] . ' ???? ???????c gi???m ??i ' . number_format($request['amount']) . '??.');
                OperatorLog::create(['operator_id' => Auth::guard('backend')->id(),
                    'content' => 'Gi???m s??? d?? hi???n c?? c???a HQPAY Merchant ' . $request['merchant_id'] . ' ' . number_format($request['amount']) . '??, m?? ?????i chi???u: ' . $request['ft_code'] . '. S??? d?? hi???n c??: ' . number_format($balance->amount),
                    'function' => json_encode(
                        [
                            'merchant_id' => $request['merchant_id'],
                            'amount' => $request['amount'],
                            'ft_code' => $request['ft_code'],
                            'status' => 'decrease',
                            'balance' => $balance->amount

                        ])
                ]);
            } else {
                Flash::error('S??? d?? c???a Merchant kh??ng ????? ????? gi???m.');
            }
        } else {
            Flash::error('Merchant ch??a ???????c x??c nh???n s??? d??.');
        }
        return redirect(route('sub-merchants.index'));
    }

    public function setTransferLimit(Request $request)
    {
        $request = $request->all();
        $request['transfer_min'] = (int)str_replace([',', '??'], '', $request['transfer_min']);
        $request['transfer_max'] = (int)str_replace([',', '??'], '', $request['transfer_max']);
        $merchant = Merchant::withoutTrashed()->find($request['merchant_id']);
        if ($merchant != null) {
            $merchant->transfer_min = $request['transfer_min'];
            $merchant->transfer_max = $request['transfer_max'];
            $merchant->save();
            Flash::success('Thi???t l???p th??nh c??ng gi???i h???n y??u c???u chi cho merchant ' . $merchant->merchant_id);

            return redirect(route('sub-merchants.index'));

        }
    }
    public function toggleReTransferable(Request $request)
    {
        $merchant = Merchant::find($request->id);
        if ($merchant->re_transferable == 0) {
            $merchant->re_transferable = 1;
        } elseif ($merchant->re_transferable == 1) {
            $merchant->re_transferable = 0;
        }

        if ($merchant->save()) {
            if ($merchant->re_transferable == 0) {
                Flash::success('Ch???c n??ng chi l???i cho merchant '.$merchant->merchant_id.' ???? M???!');
            } elseif ($merchant->re_transferable == 1) {
                Flash::success('Ch???c n??ng chi l???i cho merchant '.$merchant->merchant_id.' ???? KH??A!');
            }
            return redirect(route('sub-merchants.index'));
        }
    }
}
