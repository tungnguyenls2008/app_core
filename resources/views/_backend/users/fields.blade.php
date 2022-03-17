<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Tên') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Mật khẩu') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>

<!-- Confirmation Password Field -->
<div class="form-group col-sm-6">
      {!! Form::label('password', 'Xác nhận mật khẩu') !!}
    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
</div>
<!-- Permission Field -->
<?php
$roles=\App\Models\_Backend\Role::withoutTrashed()->get();
$role_select=[];
foreach ($roles as $role){
    $role_select[$role->id]=$role->description;
}
?>
<div class="form-group col-sm-6">
    {!! Form::label('permissions', 'Phân quyền') !!}
    {!! Form::select('permissions[]',$role_select, 8,['class' => 'form-control','multiple'=>true,'id'=>'permissions']) !!}
    <p><i>* Giữ phím Ctrl và nhấp chuột trái để chọn nhiều</i></p>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('users.index') !!}" class="btn btn-default">Cancel</a>
</div>
<script>
    $(function () {
        $('#permissions').select2({
            width: '100%',
            placeholder: 'Chọn quyền...',
            allowClear: true
        });
        @if(isset($user)&&isset($user->permissions))
        var selectedValues=JSON.parse(@json($user->permissions));
        $('#permissions').val(selectedValues).trigger('change')
        @endif
    })
</script>
