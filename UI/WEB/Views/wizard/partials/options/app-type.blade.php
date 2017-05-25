<fieldset>
	
	<legend>App options</legend>
    <div class="row">
        <div class="form-group col-xs-12">
            <div class="checkbox">
                <label>
                    {!! Form::hidden('generate_porto_container', false, ['class' => '']) !!}
                    {!! Form::checkbox('generate_porto_container', true, null, ['class' => 'icheckbox_square-blue']) !!}
                    PORTO Container
                </label>
            </div>
            <div class="checkbox">
                <label>
                    {!! Form::hidden('generate_angular_module', false) !!}
                    {!! Form::checkbox('generate_angular_module', true, null, ['class' => 'icheckbox_square-blue']) !!}
                    Angular Module
                </label>
            </div>
            <span class="help-block">For <strong>Angular module</strong> you must have your generated PORTO container on the <code>{{ app_path('Containers') }}</code> folder</span>
        </div>
        <div class="form-group col-sm-4 col-md-3">
            <label for="angular_module_location">Angular module location</label>
            {!! Form::text('angular_module_location', null, ['class' => 'form-control', 'placeholder' => base_path("../")]) !!}
            <span class="help-block">The absolute path where the Angular module will be generated.</span>
        </div>
        <div class="form-group col-sm-4 col-md-3">
            <div class="checkbox">
                <label>
                    {!! Form::hidden('group_main_apiato_classes', false) !!}
                    {!! Form::checkbox('group_main_apiato_classes', true, null, ['class' => 'icheckbox_square-blue']) !!}
                    Group main apiato classes?
                </label>
            </div>
        </div>
    </div>

</fieldset>