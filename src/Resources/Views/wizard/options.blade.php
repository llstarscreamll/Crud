@extends('core::layouts.app-sidebar')

@section('title', 'CRUD Options')

@section('styles')
    <style>
        .input-text-extra-short{
            width: 4em;
        }
        
        .input-text-short{
            width: 6em;
        }

        .input-text-medium{
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
    @component('core::components.page')
        
        @slot('title')
            <div class="col-xs-12">
                <h2>CRUD Options</h2>
            </div>
        @endslot

        <div class="panel panel-default">
            <div class="panel-body">

                @include (config('modules.crud.config.layout-namespace').'partials.notifications')
                {{-- borramos los mensajes generados por el controlador --}}
                {{ session()->forget(['success', 'error', 'warning']) }}
                
                {!! Form::model($options, [
                    'route' => 'crud.generate',
                    'method' => 'POST',
                    'name' => 'CRUD-form'
                ]) !!}

                    {!! Form::hidden('table_name', $table_name) !!}
                    
                    <div class="clearfix"></div>
                    @include('crud::wizard.partials.options.app-type')
                    
                    <div class="clearfix"></div>
                    @include('crud::wizard.partials.options.tests-and-seeder-options')

                    <div class="clearfix"></div>
                    @include('crud::wizard.partials.options.frontend-components')

                    <div class="clearfix"></div>
                    @include('crud::wizard.partials.options.entity-attributes')

                    <div class="clearfix"></div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <span class="fa fa-magic"></span>
                            <span>Generar</span>
                        </button>
                    </div>

                {!! Form::close() !!}
                
            </div>
        </div>
    @endcomponent

    <div class="clearfix"></div>
    
@endsection

@section('scripts')
    <!-- iCheck skins -->
    <link href="{{ asset('plugins/icheck/skins/square/blue.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/icheck/skins/square/red.css') }}" rel="stylesheet" type="text/css" />
    
    <script type="text/javascript">
        {{-- Inicializa el componente BootstrapSwitch --}}
        $(".bootstrap_switch").bootstrapSwitch();

        {{-- Inicializa el componente iCheck --}}
        $('.icheckbox_square-blue').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue'
        });
        $('.icheckbox_square-red').iCheck({
            checkboxClass: 'icheckbox_square-red',
            radioClass: 'iradio_square-red'
        });
    </script>

@stop()