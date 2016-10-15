<div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
    {!! Form::label('table_name', 'Nombre de la Tabla') !!}
    {!! Form::text('table_name', null, ['class' => 'form-control']) !!}
    {!!$errors->first('user_id', '<span class="text-danger">:message</span>')!!}
</div>

<div class="clearfi"></div>

<div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
    {!! Form::checkbox(
        'create_package',
        '1',
        null,
        [
            'class'         => 'bootstrap_switch',
            'data-on-text'  => 'Si',
            'data-off-text' => 'No',
            'data-off-color'=> 'danger',
            'data-on-color' => 'success',
        ])
    !!}
    {!! Form::label('create_package', 'Crear Paquete Laravel?') !!}
    {!!$errors->first('create_package', '<span class="text-danger">:message</span>')!!}
</div>