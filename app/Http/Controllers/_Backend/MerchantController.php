<?php

namespace App\Http\Controllers\_Backend;

use App\Http\Requests\CreateMerchantRequest;
use App\Http\Requests\UpdateMerchantRequest;
use App\Models\_Backend\OperatorLog;
use App\Models\Merchant;
use App\Repositories\MerchantRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Response;

class MerchantController extends AppBaseController
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
        $merchants = Merchant::withoutTrashed()->where(['is_sub_merchant'=>0]);
        $search = $request->post();
        $merchants=querySearch($search,$merchants);
        $merchants= $merchants->paginate(15)->appends($search);
        return view('_backend.merchants.index')
            ->with('merchants', $merchants);
    }

    /**
     * Show the form for creating a new Merchant.
     *
     * @return Response
     */
    public function create()
    {
        return view('_backend.merchants.create');
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

        return redirect(route('merchants.index'));
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

            return redirect(route('merchants.index'));
        }

        return view('_backend.merchants.show')->with('merchant', $merchant);
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
            OperatorLog::create(['operator_id'=>Auth::guard('backend')->id(),'content'=>'Đổi thẻ mặc định cho Merchant '.$merchant->merchant_id]);

            Flash::success('Thay đổi thẻ mặc định thành công cho merchant '.$merchant->merchant_id);
        }else{
            Flash::error('Không tìm thấy Merchant.');
        }
        return redirect(route('merchants.index'));
    }
}
