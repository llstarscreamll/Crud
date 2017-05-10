@extends('crud::layouts.top-navbar')

@section('title', 'CRUD Options')

@section('styles')
    <style>
        .column-width-extra-short{
            width: 4em;
        }
        
        .column-width-short{
            width: 6em;
        }

        .column-width-medium{
            width: 8em;
        }

        .table{
            font-size: 12px;
            margin-bottom: 20px;
        }

        .table th,
        .table td{
            text-align: center;
            padding: 5px !important;
        }
    </style>
@endsection

@section('content')	
        
        {{-- page title --}}
        <div class="page-header">
            <h1>CRUD Options for <strong>{{ request('table_name', null) }}</strong> table</h1>
        </div>

        {{-- panel with main content --}}
        <div class="panel panel-default">
            <div class="panel-body">
                {!! Form::model($options, [
                    'method' => 'GET',
                    'name' => 'update-table-form',
                    'id' => 'update-table-form',
                ]) !!}

                {!! Form::close() !!}
                
                {!! Form::model($options, [
                    'route' => 'crud.generate',
                    'method' => 'POST',
                    'name' => 'CRUD-form'
                ]) !!}

                    <div class="row">
                        <div class="col-md-6">
                            @include('crud::wizard.partials.table-list-control')
                        </div>

                        <div class="col-md-6">
                            @include('crud::wizard.partials.options-submit-btn')
                        </div>
                    </div>

                    @include('crud::partials.notifications')

                    {{-- delete msgs --}}
                    {{ session()->forget(['success', 'error', 'warning']) }}

                    {!! Form::hidden('table_name', $table_name) !!}
                    
                    <div class="clearfix"></div>
                    @include('crud::wizard.partials.options.app-type')
                    
                    <div class="clearfix"></div>
                    <div class="hidden">
                    @include('crud::wizard.partials.options.tests-and-seeder-options')
                    </div>

                    <div class="hidden">
                    <div class="clearfix"></div>
                    @include('crud::wizard.partials.options.frontend-components')
                    </div>

                    <fieldset>
                        <legend>Copy generated container/module to...</legend>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="copy_porto_container_to">Copy PORTO container to</label>
                                {!! Form::text('copy_porto_container_to', null, ['class' => 'form-control']) !!}
                                <span class="help-block">The destination folder to copy the generated container.</span>
                                <span class="help-block">The default folder output is <code>{{ storage_path('app/crud/code/PortoContainers') }}</code>.</span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="copy_angular_module_to">Copy Angular module to</label>
                                {!! Form::text('copy_angular_module_to', null, ['class' => 'form-control']) !!}
                                <span class="help-block">The destination folder to copy the generated module.</span>
                                <span class="help-block">The default folder output is <code>{{ storage_path('app/crud/code/Angular2') }}</code>.</span>
                            </div>
                        </div>
                    </fieldset>

                    <div class="clearfix"></div>
                    @include('crud::wizard.partials.options.entity-attributes')

                    <div class="clearfix"></div>

                    @include('crud::wizard.partials.options-submit-btn')

                {!! Form::close() !!}

            </div>
                
        </div>

    <div class="clearfix"></div>
    
@endsection

@section('scripts')
    <!-- iCheck skins -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/blue.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>
    
    <script type="text/javascript">
        {{-- init BootstrapSwitch --}}
        $(".bootstrap_switch").bootstrapSwitch();

        {{-- init iCheck --}}
        $('.icheckbox_square-blue').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue'
        });
    </script>

@stop()