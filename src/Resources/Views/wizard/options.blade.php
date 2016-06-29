@extends(config('llstarscreamll.CrudGenerator.config.layout'))

@section('title') Opciones CRUD @stop

@section('style')
<style type="text/css">
    
    .input-text-extra-short{
        width: 4em;
    }
    
    .input-text-short{
        width: 6em;
    }

    .input-text-medium{
        width: 8em;
    }

</style>

@endsection

@section('content')
    
    <div class="content-header">
		<h1><a href="{{route('crudGenerator.index')}}">CrudGenerator</a></h1>
	</div>
	
    <div class="content">
        
        <div class="box">
            
            <div class="box-header">

                <div class="row">

                </div>

                @include (config('llstarscreamll.CrudGenerator.config.layout-namespace').'layout.notifications')

            </div>

            <div class="panel-body">
                
                {!! Form::model($options, ['route' => 'crudGenerator.generate', 'method' => 'POST', 'name' => 'CRUD-form']) !!}

                    <fieldset>
                        <legend>Tests & Seeders</legend>
                        <div class="row">

                            {!! Form::hidden('table_name', $table_name) !!}

                            <div class="form-group col-sm-4 col-md-2">
                                <label>
                                    Usar Faker?
                                </label>
                                <br>
                                {!! Form::checkbox('use_faker', true, null, [
                                    'class' => 'bootstrap_switch',
                                    'data-size' => 'medium',
                                    'data-on-text' => 'SI',
                                    'data-off-text' => 'NO',
                                ]) !!}
                            </div>

                            <div class="form-group col-sm-4 col-md-2">
                                <label>
                                    Usar Clase Base?
                                </label>
                                <br>
                                {!! Form::checkbox('use_base_class', true, null, [
                                    'class' => 'bootstrap_switch',
                                    'data-size' => 'medium',
                                    'data-on-text' => 'SI',
                                    'data-off-text' => 'NO',
                                ]) !!}
                            </div>

                            <div class="form-group col-sm-4 col-md-2">
                                <label>
                                    Crear empleados?<br>
                                </label>
                                <br>
                                {!! Form::checkbox('create_employees_data', true, null, [
                                    'class' => 'bootstrap_switch',
                                    'data-size' => 'medium',
                                    'data-on-text' => 'SI',
                                    'data-off-text' => 'NO',
                                ]) !!}
                            </div>

                            <div class="form-group col-sm-4 col-md-2">
                                <label>
                                    Crear permisos?<br>
                                </label>
                                <br>
                                {!! Form::checkbox('create_permissions', true, null, [
                                    'class' => 'bootstrap_switch',
                                    'data-size' => 'medium',
                                    'data-on-text' => 'SI',
                                    'data-off-text' => 'NO',
                                ]) !!}
                            </div>

                        </div>
                    </fieldset>
                    
                    <div class="clearfix"></div>

                    <fieldset>
                        <legend>Componentes Frontend</legend>
                        <div class="row">

                            <div class="form-group col-sm-4 col-md-2">
                                <label>
                                    CheckboxComponent on Table<br>
                                </label>
                                <br>
                                <label>
                                    {!! Form::radio('checkbox_component_on_index_table', 'iCheck', null, ['class' => 'icheckbox_square-blue']) !!}
                                    iCheck
                                </label>
                                <br>
                                <label>
                                    {!! Form::radio('checkbox_component_on_index_table', 'BootstrapSwitch', null, ['class' => 'icheckbox_square-blue']) !!}
                                    BootstrapSwitch
                                </label>
                            </div>

                            <div class="form-group col-sm-4 col-md-2">
                                <label>
                                    Usar DateTimePicker en Formularios?<br>
                                </label>
                                <br>
                                {!! Form::checkbox('use_DateTimePicker_on_form_fields', true, null, [
                                    'class' => 'bootstrap_switch',
                                    'data-size' => 'medium',
                                    'data-on-text' => 'SI',
                                    'data-off-text' => 'NO',
                                ]) !!}
                            </div>

                            <div class="form-group col-sm-4 col-md-2">
                                <label>
                                    Usar Bootbox para acciones de confirmación?<br>
                                </label>
                                <br>
                                {!! Form::checkbox('use_modal_confirmation_on_delete', true, null, [
                                    'class' => 'bootstrap_switch',
                                    'data-size' => 'medium',
                                    'data-on-text' => 'SI',
                                    'data-off-text' => 'NO',
                                ]) !!}
                            </div>

                        </div>
                    </fieldset>

                    <div class="clearfix"></div>

                    <fieldset>
                        <legend>Atributos de Entidad</legend>
                        <div class="row">

                            <div class="form-group col-sm-4 col-md-2">
                                {!! Form::label('plural_entity_name', 'Nombre plural') !!}
                                {!! Form::text('plural_entity_name', null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-sm-4 col-md-2">
                                {!! Form::label('single_entity_name', 'Nombre singular') !!}
                                {!! Form::text('single_entity_name', null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-sm-4 col-md-3">
                                {!! Form::label('id_for_user', 'Id para usuario') !!}
                                {!! Form::select('id_for_user', ($names_list = collect($fields)->lists('name', 'name')), isset($names_list['name']) ? $names_list['name'] : null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-xs-12">
                                <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="6" class="text-center">DB</th>
                                            <th colspan="4" class="text-center">Model</th>
                                            <th colspan="3" class="text-center">HTML</th>
                                            <th colspan="2" class="text-center">Test</th>
                                            <th colspan="1" class="text-center">Validation</th>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Required?</th>
                                            <th>DefaultValue</th>
                                            <th>Key</th>
                                            <th>MaxLen.</th>
                                            <th>Namespace</th>
                                            <th>Relation</th>
                                            <th>Fillable?</th>
                                            <th>Hidden?</th>
                                            <th>OnCreateForm?</th>
                                            <th>OnUpdateForm?</th>
                                            <th>Label</th>
                                            <th>TestData</th>
                                            <th>TestData(Update)</th>
                                            <th>Validation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for($i = 0; $i < count($fields); $i++)
                                        <tr>
                                            <td>
                                                {!! Form::text("field[$i][name]", $fields[$i]->name, ['class' => 'form-control']) !!}
                                            </td>
                                            <td>
                                                {!! Form::text("field[$i][type]", $fields[$i]->type, ['class' => 'form-control input-text-medium']) !!}
                                            </td>
                                            <td>
                                                {!! Form::checkbox("field[$i][required]", $fields[$i]->required, $fields[$i]->required, [
                                                    'class' => 'bootstrap_switch',
                                                    'data-size' => 'small',
                                                    'data-on-text' => 'SI',
                                                    'data-off-text' => 'NO',
                                                ]) !!}
                                            </td>
                                            <td>
                                                {!! Form::text("field[$i][defValue]", $fields[$i]->defValue, ['class' => 'form-control input-text-short']) !!}
                                            </td>
                                            <td>
                                                {!! Form::text("field[$i][key]", $fields[$i]->key, ['class' => 'form-control input-text-extra-short', 'maxlength' => 3]) !!}
                                            </td>
                                            <td>
                                                {!! Form::number("field[$i][maxLength]", $fields[$i]->maxLength, ['class' => 'form-control']) !!}
                                            </td>
                                            <td>
                                                {!! Form::text("field[$i][namespace]", null, ['class' => 'form-control']) !!}
                                            </td>
                                            <td>
                                                {!! Form::select("field[$i][relation]",
                                                    [
                                                    '' => '---',
                                                    'hasOne' => 'hasOne',
                                                    'belongsTo' => 'belongsTo',
                                                    'hasMany' => 'hasMany',
                                                    'belongsToMany' => 'belongsToMany',
                                                    ],
                                                    null,
                                                    ['class' => 'form-control']
                                                ) !!}
                                            </td>
                                            <td>
                                                {!! Form::checkbox("field[$i][fillable]", true, null, [
                                                    'class' => 'bootstrap_switch',
                                                    'data-size' => 'small',
                                                    'data-on-text' => 'SI',
                                                    'data-off-text' => 'NO',
                                                ]) !!}
                                            </td>
                                            <td>
                                                {!! Form::checkbox("field[$i][hidden]", true, null, [
                                                    'class' => 'bootstrap_switch',
                                                    'data-size' => 'small',
                                                    'data-on-text' => 'SI',
                                                    'data-off-text' => 'NO',
                                                ]) !!}
                                            </td>
                                            <td>
                                                {!! Form::checkbox("field[$i][on_create_form]", true, null, [
                                                    'class' => 'bootstrap_switch',
                                                    'data-size' => 'small',
                                                    'data-on-text' => 'SI',
                                                    'data-off-text' => 'NO',
                                                ]) !!}
                                            </td>
                                            <td>
                                                {!! Form::checkbox("field[$i][on_update_form]", true, null, [
                                                    'class' => 'bootstrap_switch',
                                                    'data-size' => 'small',
                                                    'data-on-text' => 'SI',
                                                    'data-off-text' => 'NO',
                                                ]) !!}
                                            </td>
                                            <td>
                                                {!! Form::text("field[$i][label]", null, ['class' => 'form-control', 'required', 'placeholder' => $fields[$i]->name.' label']) !!}
                                            </td>
                                            <td>
                                                {!! Form::text("field[$i][testData]", null, ['class' => 'form-control', 'placeholder' => 'null']) !!}
                                            </td>
                                            <td>
                                                {!! Form::text("field[$i][testDataUpdate]", null, ['class' => 'form-control', 'placeholder' => 'null']) !!}
                                            </td>
                                            <td>
                                                {!! Form::text("field[$i][validation_rules]", null, ['class' => 'form-control', 'placeholder' => $fields[$i]->name.' rules']) !!}
                                            </td>
                                        </tr>
                                        @endfor
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                                </div>
                            </div>

                        </div>
                    </fieldset>
                    
                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-primary">
                                <span class="fa fa-magic"></span>
                                <span>Generar</span>
                            </button>
                        </div>
                    </div>

                {!! Form::close() !!}
                
            </div>
        </div>
    </div>
    
@endsection

@section('script')
    <!-- Componente iCheck -->
    <link href="{{ asset('resources/CoreModule/admin-lte/plugins/iCheck/square/blue.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('resources/CoreModule/admin-lte/plugins/iCheck/square/red.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('resources/CoreModule/admin-lte/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        {{-- Inicializa el componente BootstrapSwitch --}}
        $(".bootstrap_switch").bootstrapSwitch();

        {{-- Inicializa el componente iCheck --}}
        $('.icheckbox_square-blue').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
        $('.icheckbox_square-red').iCheck({
            checkboxClass: 'icheckbox_square-red',
            radioClass: 'iradio_square-red',
            increaseArea: '20%' // optional
        });
    </script>

@stop()