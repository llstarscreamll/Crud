@extends('CoreModule::app')

@section('title') Opciones CRUD @stop

@section('style')

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

                @include ('CoreModule::layout.notifications')

            </div>

            <div class="panel-body">
                
                {!! Form::open(['route' => 'crudGenerator.generate', 'method' => 'POST']) !!}
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
                        <table class="table">
                            <thead>
                                <th>DB Column</th>
                                <th>Type</th>
                                <th>Required?</th>
                                <th>DefaultValue</th>
                                <th>Key</th>
                                <th>MaxLen.</th>
                                <th>Fillable?</th>
                                <th>Hidden?</th>
                                <th>Form Field?</th>
                                <th>On Update Form?</th>
                                <th>TestData</th>
                                <th>TestData(Update)</th>
                                <th>Label</th>
                                <th>Validation</th>
                            </thead>
                            <tbody>
                                @for($i = 0; $i < count($fields); $i++)
                                <tr>
                                    <td>
                                        {!! Form::text("field[$i][name]", $fields[$i]->name, ['class' => 'form-control']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text("field[$i][type]", $fields[$i]->type, ['class' => 'form-control']) !!}
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
                                        {!! Form::text("field[$i][defValue]", $fields[$i]->defValue, ['class' => 'form-control']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text("field[$i][key]", $fields[$i]->key, ['class' => 'form-control']) !!}
                                    </td>
                                    <td>
                                        {!! Form::number("field[$i][maxLength]", $fields[$i]->maxLength, ['class' => 'form-control']) !!}
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
                                        {!! Form::checkbox("field[$i][in_form_field]", true, null, [
                                            'class' => 'bootstrap_switch',
                                            'data-size' => 'small',
                                            'data-on-text' => 'SI',
                                            'data-off-text' => 'NO',
                                        ]) !!}
                                    </td>
                                    <td>
                                        {!! Form::checkbox("field[$i][on_update_form_field]", true, null, [
                                            'class' => 'bootstrap_switch',
                                            'data-size' => 'small',
                                            'data-on-text' => 'SI',
                                            'data-off-text' => 'NO',
                                        ]) !!}
                                    </td>
                                    <td>
                                        {!! Form::text("field[$i][testData]", null, ['class' => 'form-control', 'placeholder' => 'null']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text("field[$i][testDataUpdate]", null, ['class' => 'form-control', 'placeholder' => 'null']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text("field[$i][label]", null, ['class' => 'form-control', 'required', 'placeholder' => $fields[$i]->name.' label']) !!}
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
                    
                    <div class="clearfix"></div>
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

    <script type="text/javascript">
    
        $(".bootstrap_switch").bootstrapSwitch();
        
    </script>

@stop()