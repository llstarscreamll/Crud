@extends('theme::Inspinia.layouts.app-sidebar')

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
    @component('theme::Inspinia.components.page')
        
        @slot('title')
            <div class="col-xs-12">
                <h2>CRUD Options</h2>
            </div>
        @endslot

        @component('theme::Inspinia.components.box')
            @slot('title')
                <h5>CRUD options</h5>
                @component('theme::Inspinia.components.box-tools')
                @endcomponent
            @endslot

                @include('theme::Inspinia.partials.notifications')

                {{-- delete msgs --}}
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
                    <div class="hidden">
                    @include('crud::wizard.partials.options.tests-and-seeder-options')
                    </div>

                    <div class="hidden">
                    <div class="clearfix"></div>
                    @include('crud::wizard.partials.options.frontend-components')
                    </div>

                    <fieldset>
                        <legend>Copy dirs to...</legend>
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

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <span class="fa fa-magic"></span>
                            <span>Generar</span>
                        </button>
                    </div>

                {!! Form::close() !!}
                
        @endcomponent
    @endcomponent

    <div class="clearfix"></div>
    
@endsection

@section('scripts')
    <!-- iCheck skins -->
    <link href="{{ asset('plugins/icheck/skins/square/blue.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/icheck/skins/square/red.css') }}" rel="stylesheet" type="text/css" />
    
    <script type="text/javascript">
        {{-- init BootstrapSwitch --}}
        $(".bootstrap_switch").bootstrapSwitch();

        {{-- init iCheck --}}
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