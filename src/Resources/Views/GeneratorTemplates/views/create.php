<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
@extends('<?=config('modules.CrudGenerator.config.layout')?>')

@section('title') {{trans('<?=$gen->getLangAccess()?>/views.create.name').trans('<?=$gen->getLangAccess()?>/views.module.name-singular')}} @stop

@section('style')
@endsection

@section('content')

    <div class="content-header">
        <h1>
            <a href="{{route('<?=$gen->route()?>.index')}}">{{trans('<?=$gen->getLangAccess()?>/views.module.name')}}</a>
            <small>{{trans('<?=$gen->getLangAccess()?>/views.create.name')}}</small>
        </h1>
    </div>
    
    <div class="content">
        
        <div class="box">
            
            <div class="box-header">
                @include ('<?=config('modules.CrudGenerator.config.layout-namespace')?>layout.notifications')
            </div>

            <div class="box-body">
                
                {!! Form::open(['route' => '<?=$gen->route()?>.store', 'method' => 'POST', 'name' => 'create-<?=$gen->getDashedModelName()?>-form']) !!}

                    @include('<?=$gen->viewsDirName()?>.partials.form-fields')

                    <div class="clearfix"></div>
                    
                    <div class="form-group col-sm-6">
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-floppy-disk"></span>
                            <span class="">{{trans('<?=$gen->getLangAccess()?>/views.create.btn-create')}}</span>
                        </button>
                        <span id="helpBlock" class="help-block">{!!trans('<?=$gen->getLangAccess()?>/views.inputs-required-help')!!}</span>
                    </div>

                {!! Form::close() !!}
                
            </div>

        </div>

    </div>

@endsection

@section('script')

<?php if ($gen->hasSelectFields($fields)) { ?>
    {{-- Componente Bootstrap-Select, este componente se inicializa automáticamente --}}
    <script src="{{ asset('resources/<?=config('modules.CrudGenerator.config.core-assets-namespase')?>bootstrap-select/dist/css/bootstrap-select.min.css') }}"></script>
    <script src="{{ asset('resources/<?=config('modules.CrudGenerator.config.core-assets-namespase')?>bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('resources/<?=config('modules.CrudGenerator.config.core-assets-namespase')?>bootstrap-select/dist/js/i18n/defaults-es_CL.min.js') }}"></script>

<?php } ?>
<?php if ($gen->hasDateFields($fields) || $gen->hasDateTimeFields($fields)) { ?>
    {{-- Componente Bootstrap DateTimePicker --}}
    <link rel="stylesheet" href="{{ asset('resources/<?=config('modules.CrudGenerator.config.core-assets-namespase')?>eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}"/>
    <script src="{{ asset('resources/<?=config('modules.CrudGenerator.config.core-assets-namespase')?>moment/min/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('resources/<?=config('modules.CrudGenerator.config.core-assets-namespase')?>eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

<?php } ?>
    <script type="text/javascript">

<?php if ($gen->hasDateFields($fields) || $gen->hasDateTimeFields($fields)) { ?>
        {{-- Configuración de Bootstrap DateTimePicker --}}
<?php foreach ($fields as $key => $field) { ?>
<?php if ($field->type == 'date' && $field->on_create_form) { ?>
        $('input[name=<?= $field->name ?>]').datetimepicker({
            locale: '{{ Lang::locale() }}',
            format: 'YYYY-MM-DD'
        });
<?php } elseif (($field->type == 'timestamp' || $field->type == 'datetime') && $field->on_create_form) { ?>
        $('input[name=<?= $field->name ?>]').datetimepicker({
            locale: '{{Lang::locale()}}',
            format: 'YYYY-MM-DD HH:mm:ss'
        });
<?php } // end if ?>
<?php } // end foreach ?>
<?php } // end if ?>
        
<?php if ($gen->hasTinyintTypeField($fields)) { ?>
        {{-- Inicializa el componente SwitchBootstrap --}}
        $(".bootstrap_switch").bootstrapSwitch();
<?php } ?>
        
    </script>

@endsection()