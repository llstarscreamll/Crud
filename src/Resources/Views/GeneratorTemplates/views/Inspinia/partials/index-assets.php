{{--
    ****************************************************************************
    Assets de Index.
    ____________________________________________________________________________
    Contiene los assets css o javascript usados en la vista index.
    ****************************************************************************

    <?= $gen->getCopyRightDocBlock() ?>
    
    ****************************************************************************
--}}

<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// si la entidad tiene campos que tengan que usar un select, incluimos los assets del componente Bootstrap-Select //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<?php if ($gen->hasSelectFields($fields)) { ?>
{{-- Bootstrap-Select --}}
<link href="{{ asset('plugins/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('plugins/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-select/dist/js/i18n/defaults-es_CL.min.js') }}"></script>
<?php } ?>
<?php if ($gen->hasTinyintTypeField($fields)) { ?>
<?php } ?>
{{-- iCheck --}}
<link href="{{ asset('plugins/icheck2/square/blue.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/icheck2/square/red.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('plugins/icheck2/icheck.min.js') }}" type="text/javascript"></script>
<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// si se quiere usar ventanas modales de confirmación para acciones como eliminar registros u otras, incluimos //
// el componente Bootbox para generarles fácilmente y con un setup mínimo                                      //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<?php if ($request->has('use_modal_confirmation_on_delete')) { ?>
{{-- Bootbox --}}
<script src="{{ asset('plugins/bootbox/bootbox.js') }}" type="text/javascript"></script>
<?php } ?>
<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// si la entidad tiene campos de fecha incluimos el componente Bootstrap DateRangePicker para lograr de forma //
// sencilla hacer las búsquedas por rangos de fecha                                                           //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<?php if ($gen->hasDateFields($fields) || $gen->hasDateTimeFields($fields)) { ?>
{{-- Bootstrap DateRangePicker --}}
<link href="{{ asset('plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('plugins/moment/min/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/bootstrap-daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
<?php } ?>