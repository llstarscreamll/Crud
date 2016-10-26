{{--
    ****************************************************************************
    Scripts de Formulario.
    ____________________________________________________________________________
    Contiene el código javascript usado en el formulario.
    ****************************************************************************

    Este archivo es parte del Books.
    (c) Johan Alvarez <llstarscreamll@hotmail.com>
    Licensed under The MIT License (MIT).

    @package    Books
    @version    0.1
    @author     Johan Alvarez
    @license    The MIT License (MIT)
    @copyright  (c) 2015-2016, Johan Alvarez <llstarscreamll@hotmail.com>
    @link       https://github.com/llstarscreamll
    
    ****************************************************************************
--}}

<script type="text/javascript">

    {{-- Configuración de Bootstrap DateTimePicker --}}
    $('input[name=published_year]').datetimepicker({
        locale: '{{ Lang::locale() }}',
        format: 'YYYY-MM-DD'
    });
    
    {{-- Inicializa el componente SwitchBootstrap --}}
    $(".bootstrap_switch").bootstrapSwitch();

    {{-- Inicialización y configuración de Bootbox --}}
    initBootBoxComponent(
        '{{ trans('book/views.index.modal-default-title') }}',
        '{{ trans('book/views.index.modal-default-btn-confirmation-label') }}',
        '{{ trans('book/views.index.modal-default-btn-confirmation-className') }}',
        '{{ trans('book/views.index.modal-default-btn-cancel-label') }}',
        '{{ trans('book/views.index.modal-default-btn-cancel-className') }}'
    );
    
</script>