<div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
    {!! Form::label('table_name', 'Nombre de la Tabla') !!}
    {!! Form::text('table_name', null, ['class' => 'form-control']) !!}
    {!!$errors->first('user_id', '<span class="text-danger">:message</span>')!!}
</div>

<div class="clearfi"></div>
