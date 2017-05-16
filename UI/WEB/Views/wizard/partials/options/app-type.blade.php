<fieldset>
	
	<legend>App Type</legend>
    <div class="row">
        <div class="form-group col-xs-12">
            <div class="radio">
                <label>
                    {!! Form::hidden('generate_porto_container', false, ['class' => '']) !!}
                    {!! Form::checkbox('generate_porto_container', true, null, ['class' => 'icheckbox_square-blue']) !!}
                    PORTO Container
                </label>
            </div>
            <div class="radio">
                <label>
                    {!! Form::hidden('generate_angular_module', false) !!}
                    {!! Form::checkbox('generate_angular_module', true, null, ['class' => 'icheckbox_square-blue']) !!}
                    Angular Module
                </label>
            </div>
            <span class="help-block">For <strong>Angular module</strong> you must have your generated PORTO container on the <code>{{ app_path('Containers') }}</code> folder</span>
        </div>
    </div>

</fieldset>