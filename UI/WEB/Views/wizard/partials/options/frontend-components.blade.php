<fieldset>
    <legend>Frontend</legend>
    <div class="row">

        <div class="form-group col-sm-6 col-md-2">
            <label>
                Check Component on Table<br>
            </label>
            <br>
            <label>
                {!! Form::radio('checkbox_component_on_index_table', 'iCheck', true, ['class' => 'icheckbox_square-blue']) !!}
                iCheck
            </label>
            <br>
            <label>
                {!! Form::radio('checkbox_component_on_index_table', 'BootstrapSwitch', null, ['class' => 'icheckbox_square-blue']) !!}
                BootstrapSwitch
            </label>
        </div>

        <div class="form-group col-sm-6 col-md-2">
            <label>
                DateTimePicker on Forms?<br>
            </label>
            <br>
            {!! Form::checkbox('use_DateTimePicker_on_form_fields', true, true, [
                'class' => 'bootstrap_switch',
                'data-size' => 'mini',
                'data-on-text' => 'Yes',
                'data-off-text' => 'Not',
            ]) !!}
        </div>

        <div class="clearfix hidden-lg"></div>

        <div class="form-group col-sm-6 col-md-2">
            <label>
                Use Bootbox for confirmations?<br>
            </label>
            <br>
            {!! Form::checkbox('use_modal_confirmation_on_delete', true, true, [
                'class' => 'bootstrap_switch',
                'data-size' => 'mini',
                'data-on-text' => 'Yes',
                'data-off-text' => 'Not',
            ]) !!}
        </div>

        <div class="form-group col-sm-6 col-md-2">
            <label>
                Use x-editable?<br>
            </label>
            <br>
            {!! Form::checkbox('use_x_editable', true, false, [
                'class' => 'bootstrap_switch',
                'data-size' => 'mini',
                'data-on-text' => 'Yes',
                'data-off-text' => 'Not',
            ]) !!}
        </div>
    </div>

    <div class="row">
        <div class="form-group col-sm-6 col-md-2">
            <label>
                Include assets?<br>
            </label>
            <br>
            {!! Form::checkbox('include_assets', true, false, [
                'class' => 'bootstrap_switch',
                'data-size' => 'mini',
                'data-on-text' => 'Yes',
                'data-off-text' => 'Not',
            ]) !!}
        </div>

        <div class="form-group col-sm-4 col-md-3">
            {!! Form::label('UI_theme', 'UI Theme') !!}
            {!! Form::select(
                'UI_theme',
                $UI_themes,
                null,
                ['class' => 'form-control']
            ) !!}
        </div>
    </div>
</fieldset>
