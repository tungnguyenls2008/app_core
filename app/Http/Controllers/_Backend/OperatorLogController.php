<?php

namespace App\Http\Controllers\_Backend;

use App\Exports\OperatorLogExport;
use App\Http\Requests\CreateOperatorLogRequest;
use App\Http\Requests\UpdateOperatorLogRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\_Backend\OperatorLog;
use Illuminate\Http\Request;
use Flash;
use Maatwebsite\Excel\Facades\Excel;
use Response;

class OperatorLogController extends AppBaseController
{
    /**
     * Display a listing of the OperatorLog.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var OperatorLog $operatorLogs */
        $operatorLogs = OperatorLog::Orderby('created_at', 'desc');
        $request = $request->all();
        $operatorLogs=querySearch($request,$operatorLogs);
        $operatorLogs = $operatorLogs->paginate(20)->appends($request);
        return view('_backend.operator_logs.index')
            ->with('operatorLogs', $operatorLogs)->with('count',$operatorLogs->total());
    }

    /**
     * Show the form for creating a new OperatorLog.
     *
     * @return Response
     */
    public function create()
    {
        return view('_backend.operator_logs.create');
    }

    /**
     * Store a newly created OperatorLog in storage.
     *
     * @param CreateOperatorLogRequest $request
     *
     * @return Response
     */
    public function store(CreateOperatorLogRequest $request)
    {
        $input = $request->all();

        /** @var OperatorLog $operatorLog */
        $operatorLog = OperatorLog::create($input);

        Flash::success('Operator Log saved successfully.');

        return redirect(route('operatorLogs.index'));
    }

    /**
     * Display the specified OperatorLog.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var OperatorLog $operatorLog */
        $operatorLog = OperatorLog::find($id);

        if (empty($operatorLog)) {
            Flash::error('Operator Log not found');

            return redirect(route('operatorLogs.index'));
        }

        return view('_backend.operator_logs.show')->with('operatorLog', $operatorLog);
    }

    /**
     * Show the form for editing the specified OperatorLog.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var OperatorLog $operatorLog */
        $operatorLog = OperatorLog::find($id);

        if (empty($operatorLog)) {
            Flash::error('Operator Log not found');

            return redirect(route('operatorLogs.index'));
        }

        return view('_backend.operator_logs.edit')->with('operatorLog', $operatorLog);
    }

    /**
     * Update the specified OperatorLog in storage.
     *
     * @param int $id
     * @param UpdateOperatorLogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOperatorLogRequest $request)
    {
        /** @var OperatorLog $operatorLog */
        $operatorLog = OperatorLog::find($id);

        if (empty($operatorLog)) {
            Flash::error('Operator Log not found');

            return redirect(route('operatorLogs.index'));
        }

        $operatorLog->fill($request->all());
        $operatorLog->save();

        Flash::success('Operator Log updated successfully.');

        return redirect(route('operatorLogs.index'));
    }

    /**
     * Remove the specified OperatorLog from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var OperatorLog $operatorLog */
        $operatorLog = OperatorLog::find($id);

        if (empty($operatorLog)) {
            Flash::error('Operator Log not found');

            return redirect(route('operatorLogs.index'));
        }

        $operatorLog->delete();

        Flash::success('Operator Log deleted successfully.');

        return redirect(route('operatorLogs.index'));
    }
    public function export()
    {
        return Excel::download(new OperatorLogExport(), 'lich_su_van_hanh_' . date('d_m_Y', time()) . '.xlsx');
    }
}
