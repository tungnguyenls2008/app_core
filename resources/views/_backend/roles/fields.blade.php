<!-- Route Field -->
<div class="form-group col-sm-6">
    {!! Form::label('route', 'Chức năng:') !!}
    {!! Form::select('route[]',$routeCollection, null, ['id'=>'routes-select','class' => 'form-control','multiple'=>true]) !!}
    <p><i>* Giữ phím Ctrl và nhấp chuột trái để chọn nhiều</i></p>

</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Mô tả:') !!}
    {!! Form::text('description', $role->description??null, ['class' => 'form-control','maxlength' => 500,'maxlength' => 500]) !!}
</div>
<script>
    $(function () {
        $('#routes-select').select2({
            width: '100%',
            placeholder: 'Chọn chức năng...',
            allowClear: true,
        });
        @if(isset($role)&&isset($role->route))
        var selectedValues=JSON.parse(@json($role->route));
        console.log(selectedValues);
        $('#routes-select').val(selectedValues).trigger('change')
        @endif
    })
</script>
