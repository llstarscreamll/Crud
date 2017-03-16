<fieldset>
	
	<legend>App Type</legend>

	<div class="form-group col-sm-6 col-md-2">
        <label>
            {!! Form::checkbox('app_type[]', 'porto_container', true, ['class' => 'icheckbox_square-blue']) !!}
            PORTO Container
        </label>
        <label>
            {!! Form::checkbox('app_type[]', 'angular_2_module', true, ['class' => 'icheckbox_square-blue']) !!}
            Angular 2 Module
        </label>
    </div>

</fieldset>