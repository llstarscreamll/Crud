<fieldset>
	
	<legend>App Type</legend>

	<div class="form-group col-sm-6 col-md-2">
        <label>
            Choose the app type to generate<br>
        </label>
        <br>
        <label>
            {!! Form::radio('app_type', 'laravel_app', true, ['class' => 'icheckbox_square-blue']) !!}
            Laravel app
        </label>
        <br>
        {{-- <label>
            {!! Form::radio('app_type', 'laravel_package', null, ['class' => 'icheckbox_square-blue']) !!}
            Laravel Package
        </label> --}}
        <label>
            {!! Form::radio('app_type', 'porto_container', null, ['class' => 'icheckbox_square-blue']) !!}
            PORTO Container
        </label>
    </div>

</fieldset>