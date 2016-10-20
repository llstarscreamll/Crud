<script type="text/javascript">

    {{-- Configuración de Bootstrap DateTimePicker --}}
    $('input[name=published_year]').datetimepicker({
        locale: '{{ Lang::locale() }}',
        format: 'YYYY-MM-DD'
    });
    
    {{-- Inicializa el componente SwitchBootstrap --}}
    $(".bootstrap_switch").bootstrapSwitch();
    
</script>