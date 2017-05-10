<fieldset>
	
	<legend>App Type</legend>
    <div class="row">
        <div class="form-group col-sm-6 col-md-4">
            <div class="radio">
                <label>
                    {!! Form::checkbox('app_type[]', 'porto_container', true, ['class' => 'icheckbox_square-blue']) !!}
                    PORTO Container
                </label>
            </div>
            <div class="radio">
                <label>
                    {!! Form::checkbox('app_type[]', 'angular_2_module', true, ['class' => 'icheckbox_square-blue']) !!}
                    Angular Module
                </label>
            </div>
            <span class="help-block">For <strong>Angular module</strong> you must have your generated PORTO container on the <code>{{ app_path('Containers') }}</code> folder</span>
        </div>
    </div>

</fieldset>