@extends(config('modules.crud.config.layout'))

@section('title') Opciones CRUD @stop

@section('styles')
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
    <div class="content">
        
        <div class="panel panel-default">
            
            <div class="panel-heading">
                Crud
            </div>

            <div class="panel-body">

                @include (config('modules.crud.config.layout-namespace').'partials.notifications')
                
                {!! Form::model($options, ['route' => 'crud.generate', 'method' => 'POST', 'name' => 'CRUD-form']) !!}

                    {!! Form::hidden('table_name', $table_name) !!}
                    
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
    </div>
    
@endsection

@section('scripts')
    <!-- iCheck -->
    <script src="{{ asset('plugins/icheck2/icheck.min.js') }}" type="text/javascript"></script>
    <link href="{{ asset('plugins/icheck2/square/blue.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/icheck2/square/red.css') }}" rel="stylesheet" type="text/css" />
    {{-- BootstrapSwitch --}}
    @if(env('APP_THEME', '') !== "Limitless")
    <link href="{{ asset('plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
    @endif
    <script src="{{ asset('plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        {{-- Inicializa el componente BootstrapSwitch --}}
        $(".bootstrap_switch").bootstrapSwitch();

        {{-- Inicializa el componente iCheck --}}
        $('.icheckbox_square-blue').icheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue'
        });
        $('.icheckbox_square-red').icheck({
            checkboxClass: 'icheckbox_square-red',
            radioClass: 'iradio_square-red'
        });
    </script>

@stop()