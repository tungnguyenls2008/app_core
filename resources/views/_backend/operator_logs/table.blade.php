<div class="table-responsive">
    <table class="table table-hover" id="operatorLogs-table">
        <thead>
        <tr>
            <th>Vận hành</th>
            <th>Thực hiện</th>
            <th>Thời gian</th>
            <th>Ghi chú</th>
{{--            <th colspan="3">Action</th>--}}
        </tr>
        </thead>
        <tbody>
        @foreach($operatorLogs as $operatorLog)
            <tr>
                <?php
                $operator=\App\Models\_Backend\User::find($operatorLog->operator_id);
                ?>
                <td>{{ $operator->name??'Merchant'}}</td>
                <td width="40%">{{ $operatorLog->content }}</td>
                <td width="10%">{{ date('d-m-Y H:i:s',strtotime($operatorLog->created_at)) }}</td>
                <td>{{ $operatorLog->function }}</td>
{{--                <td class=" text-center">--}}
                    {{--                           {!! Form::open(['route' => ['operatorLogs.destroy', $operatorLog->id], 'method' => 'delete']) !!}--}}
{{--                    <div class='btn-group'>--}}
                        {{--                               <a href="{!! route('operatorLogs.show', [$operatorLog->id]) !!}" class='btn btn-light action-btn '><i class="fa fa-eye"></i></a>--}}
                        {{--                               <a href="{!! route('operatorLogs.edit', [$operatorLog->id]) !!}" class='btn btn-warning action-btn edit-btn'><i class="fa fa-edit"></i></a>--}}
                        {{--                               {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger action-btn delete-btn', 'onclick' => 'return confirm("Are you sure want to delete this record ?")']) !!}--}}
{{--                    </div>--}}
                    {{--                           {!! Form::close() !!}--}}
{{--                </td>--}}
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $operatorLogs->links() !!}
</div>
