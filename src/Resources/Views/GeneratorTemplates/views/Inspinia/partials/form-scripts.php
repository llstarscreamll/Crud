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