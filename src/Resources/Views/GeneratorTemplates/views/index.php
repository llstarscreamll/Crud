<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>

@extends('<?=config('llstarscreamll.CrudGenerator.config.layout')?>')

@section('title') {{trans('<?=$gen->getLangAccess()?>/views.module.name')}} @endsection

@section('style')
@endsection

@section('content')
    
    <section class="content-header">
        <h1>
            <a href="{{route('<?=$gen->route()?>.index')}}">{{trans('<?=$gen->getLangAccess()?>/views.module.name')}}</a>
        </h1>
    </section>

    <section class="content">
    
        <div class="box">
            
            <div class="box-header">
                
                <div class="row tools">

                    {{-- Action Buttons --}}
                    <div class="col-md-6 action-buttons">
                        
<?php if (config('llstarscreamll.CrudGenerator.config.show-create-form-on-index') === true) { ?>
                        {{-- El boton que dispara la ventana modal con formulario de creación de registro --}}
                        <div class="display-inline-block" role="button"  data-toggle="tooltip" data-placement="top" title="{{trans('<?=$gen->getLangAccess()?>/views.index.btn-create')}}">
                            <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#create-form-modal">
                                <span class="glyphicon glyphicon-plus"></span>
                                <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.btn-create')}}</span>
                            </button>
                        </div>
<?php } else { ?>
                        {{-- Link que lleva a la página con el formulario de creación de registro --}}
                        <a id="create-<?=$gen->route()?>-link" class="btn btn-default btn-sm" href="{!! route('<?=$gen->route()?>.create') !!}" role="button"  data-toggle="tooltip" data-placement="top" title="{{trans('<?=$gen->getLangAccess()?>/views.index.btn-create')}}">
                            <span class="glyphicon glyphicon-plus"></span>
                            <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.btn-create')}}</span>
                        </a>
<?php } ?>
                    
                    </div>

                    @include('<?=config('llstarscreamll.CrudGenerator.config.layout-namespace')?>layout.notifications')

                </div>
                
            </div>
            
            <div class="box-body">

                {{-- La tabla de datos --}}
                @include('<?=$gen->viewsDirName()?>.partials.index-table')

            </div>
        
        </div>    
    
    </section>

<?php if (config('llstarscreamll.CrudGenerator.config.show-create-form-on-index') === true) { ?>
    {{-- Formulario de creación de registro --}}
    @include('<?=$gen->viewsDirName()?>.partials.index-create-form')
<?php } ?>

@endsection

@section('script')
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
<?php if ($gen->hasDateFields($fields) || $gen->hasDateTimeFields($fields)) { ?>
    {{-- Dependencias de datetimepicker para componente x-editable --}}
    <link href="{{ asset('resources/CoreModule/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"></link> 
    <script src="{{ asset('resources/CoreModule/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('resources/CoreModule/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.es.js') }}"></script>
<?php } ?>
    
    <script>
        {{-- Configuración del componente x-editable --}}
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $(".editable").editable({ajaxOptions:{method:'PUT'}});

<?php if ($gen->hasDateFields($fields)) { ?>
        {{-- Configuración del componente x-editable para el caso de campos de tipo "date" --}}
        $('.editable-date').editable({
            ajaxOptions:{method:'PUT'},
            format: 'yyyy-mm-dd',
            viewformat: 'dd/mm/yyyy',
            datetimepicker: {
                todayBtn: 'linked',
                weekStart: 1,
                language: 'es'
            }
        });
<?php } ?>

<?php if ($gen->hasDateTimeFields($fields)) { ?>
        {{-- Configuración del componente x-editable para el caso de campos de tipo "datetime" --}}
        $('.editable-datetime').editable({
            ajaxOptions:{method:'PUT'},
            format: 'yyyy-mm-dd hh:ii:ss',
            viewformat: 'dd/mm/yyyy hh:ii:ss',
            datetimepicker: {
                todayBtn: 'linked',
                weekStart: 1,
                language: 'es'
            }
        });
<?php } ?>

<?php if ($gen->hasTinyintTypeField($fields)) { ?>
        {{-- Inicializa el componente SwitchBootstrap --}}
        $(".bootstrap_switch").bootstrapSwitch();
<?php } ?>

    </script>
@endsection