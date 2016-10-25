<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
{{--
    ****************************************************************************
    Vista Index.
    ____________________________________________________________________________
    En esta vista se muestra una tabla con registros de la base de datos (ver
    partials.index-table), se muestran botones a acciones y/o links de acceso a
    otras secciones, por ejemplo eliminar o crear registros (revisar
    partials.index-buttons).

    En el footer del panel se muestra la versión de este paquete, el cual vincula
    al changelog.
    ****************************************************************************

    <?= $gen->getViewCopyRightDocBlock() ?>
    
    ****************************************************************************
--}}

@extends('<?=config('modules.CrudGenerator.config.layout')?>')

{{-- page title --}}
@section('title') {{trans('<?=$gen->getLangAccess()?>/views.module.name')}} @endsection
{{-- /page title --}}

{{-- view styles --}}
@section('styles')
@endsection
{{-- /view styles --}}

{{-- page content --}}
@section('content')

{{-- heading --}}
@include('<?=$gen->viewsDirName()?>.partials.heading')

{{-- content --}}
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-xs-12 animated fadeInRight">
            <div class="ibox float-e-margins">

            {{-- box content --}}
            <div class="ibox-content">
                
                {{-- botonera --}}
                @include('<?=$gen->viewsDirName()?>.partials.index-buttons')
                
                {{-- notificaciones --}}
                @include('<?=config('modules.CrudGenerator.config.layout-namespace')?>partials.notifications')
                
                {{-- tabla de datos --}}
                @include('<?=$gen->viewsDirName()?>.partials.index-table')

            </div>
            {{-- /box content --}}

            {{-- box footer --}}
            <div class="ibox-footer">
                <span class="pull-right">
                    <a href="#"><strong>v0.1</strong></a>
                </span>
                <div class="clearfix"></div>
            </div>
            {{-- /box footer --}}
            </div>{{-- /ibox --}}
        </div>{{-- /col-**-** --}}
    </div>{{-- /row --}}
</div>
{{-- /content --}}

@endsection
{{-- /page content --}}

{{-- view scripts--}}
@section('scripts')

@include('<?=$gen->viewsDirName()?>.partials.index-assets')
@include('<?=$gen->viewsDirName()?>.partials.form-assets')
@include('<?=$gen->viewsDirName()?>.partials.form-scripts')

<script>

<?php
/////////////////////////////////////////////////////////////////////////////////////
// lineas para mejorar el comportamiento de selección de los elementos de la tabla //
/////////////////////////////////////////////////////////////////////////////////////
?>
    $(document).ready(function() {
        {{-- Inicializa las mejoras de selección en la tabla --}}
        setupTableSelectionAddons();
        {{-- Inicializa el componente iCheck --}}
        initiCheckPlugin();
        {{-- Previene que se esconda el dropdown al hacer clic en sus elementos hijos --}}
        preventDropDownHide();
<?php if ($gen->hasTinyintTypeField($fields)) { ?>
        {{-- Inicializa el componente BootstrapSwitch --}}
        $(".bootstrap_switch").bootstrapSwitch();
<?php } ?>
    });

<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////
// creamos las variables regionales y algunos rango de fechas pedeterminados para el componente Bootstrap //
// DateRangePicker si es que hay campos de fecha                                                          //
////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<?php if ($gen->hasDateFields($fields) || $gen->hasDateTimeFields($fields)) { ?>
    {{-- Configuración regional para Bootstrap DateRangePicker --}}
    dateRangePickerLocaleSettings = @include('<?=config('modules.CrudGenerator.config.layout-namespace')?>shared.dateRangePickerLocales')

    {{-- Algunos rangos de fecha predeterminados para Bootstrap DateRangePicker --}}
    dateRangePickerRangesSettings = @include('<?=config('modules.CrudGenerator.config.layout-namespace')?>shared.dateRangePickerRanges')

    let dateRangeFields = [
<?php foreach ($fields as $key => $field) { ?>
<?php if ($field->type == 'date') { ?>
        {
            field: 'input[name="<?= $field->name ?>[informative]"]',
            format: 'YYYY-MM-DD',
            with_time_picker: false,
            opens: 'center',
        },
<?php } elseif ($field->type == 'timestamp' || $field->type == 'datetime') { ?>
        {
            field: 'input[name="<?= $field->name ?>[informative]"]',
            format: 'YYYY-MM-DD HH:mm:ss',
            with_time_picker: true,
            opens: 'left',
        },
<?php } // end if ?>
<?php } // end foreach ?>
    ];

    {{-- Configuración de Bootstrap DateRangePicker --}}
    setupDateRangePickers(
        dateRangeFields,
        dateRangePickerLocaleSettings,
        dateRangePickerRangesSettings
    );

<?php } // end if ?>
<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// si hay campos de tipo booleano inicializamos el componente BootstrapSwitch y iCheck los cualales son usados en el formulario de //
// creación de un registro de ĺa entidad y en los campos del formulario de búsqueda avanzada en la tabla                           //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
</script>
<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Inclusión y setup de componente Bootstrap 3 Editable, el setup comprende también algunos parámetros para los campos //
// de tipo fecha/fecha y hora si es que los hay                                                                        //
// NOTA:                                                                                                               //
// - Muy importante dejar este componente aquí pues el compoente que usa Bootstrap 3 Editable para las fechas hace     //
//   colición con el compoente Bootstrap DateTimePicker, ambos usan los mismos nombres...                              //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

{{-- Inicializa y configura x-editable --}}
@include('<?=config('modules.CrudGenerator.config.layout-namespace')?>shared.x-editable')

@endsection