<fieldset>
    <legend>Tests & Seeders</legend>

    <div class="row">

        <div class="form-group col-sm-4 col-md-2">
            <label>
                Use Faker?
            </label>
            <br>
            {!! Form::checkbox('use_faker', true, null, [
                'class' => 'bootstrap_switch',
                'data-size' => 'mini',
                'data-on-text' => 'SI',
                'data-off-text' => 'NO',
            ]) !!}
        </div>

        <div class="form-group col-sm-4 col-md-2">
            <label>
                Use Base Class?
            </label>
            <br>
            {!! Form::checkbox('use_base_class', true, null, [
                'class' => 'bootstrap_switch',
                'data-size' => 'mini',
                'data-on-text' => 'SI',
                'data-off-text' => 'NO',
            ]) !!}
        </div>

        <div class="form-group col-sm-4 col-md-2">
            <label>
                Create employees?<br>
            </label>
            <br>
            {!! Form::checkbox('create_employees_data', true, null, [
                'class' => 'bootstrap_switch',
                'data-size' => 'mini',
                'data-on-text' => 'SI',
                'data-off-text' => 'NO',
            ]) !!}
        </div>

        <div class="form-group col-sm-4 col-md-2">
            <label>
                Crear permissions?<br>
            </label>
            <br>
            {!! Form::checkbox('create_permissions', true, true, [
                'class' => 'bootstrap_switch',
                'data-size' => 'mini',
                'data-on-text' => 'SI',
                'data-off-text' => 'NO',
            ]) !!}
        </div>

    </div>
</fieldset>
