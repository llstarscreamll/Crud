{{--
    ****************************************************************************
    Scripts de Formulario.
    ____________________________________________________________________________
    Contiene el código javascript usado en el formulario.
    ****************************************************************************

    <?= $crud->getViewCopyRightDocBlock() ?>
    
    ****************************************************************************
--}}

<script type="text/javascript">
<?php if ($crud->hasDateFields($fields) || $crud->hasDateTimeFields($fields)) { ?>

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
    
<?php if ($crud->hasTinyintTypeField($fields)) { ?>
    {{-- Inicializa el componente SwitchBootstrap --}}
    $(".bootstrap_switch").bootstrapSwitch();
    
<?php } ?>
<?php if ($request->has('use_modal_confirmation_on_delete')) { ?>
    {{-- Inicialización y configuración de Bootbox --}}
    initBootBoxComponent(
        '{{ trans('<?=$crud->getLangAccess()?>.index.modal-default-title') }}',
        '{{ trans('<?=$crud->getLangAccess()?>.index.modal-default-btn-confirmation') }}',
        'btn-primary',
        '{{ trans('<?= $crud->solveSharedResourcesNamespace() ?>.modal-default-btn-cancel') }}',
        'btn-default'
    );
<?php } ?>
    
</script>