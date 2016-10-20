@extends('core::layouts.app-sidebar')

@section('title') {{trans('book/views.module.name')}} @endsection

@section('styles')
@endsection

@section('content')
    <section class="content">
    
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <a href="{{route('books.index')}}">{{trans('book/views.module.name')}}</a>
            </div>

            <div class="panel-body">
                
                <div class="row tools">

                    {{-- Action Buttons --}}
                    <div class="col-md-6 action-buttons">
                    @if (Request::get('trashed_records') != 'onlyTrashed')

                    {{-- Formulario para borrar resgistros masivamente --}}
                    {!! Form::open(['route' => ['books.destroy', 0], 'method' => 'DELETE', 'id' => 'deleteMassivelyForm', 'class' => 'form-inline display-inline']) !!}
                        
                        {{-- Botón que muestra ventana modal de confirmación para el envío del formulario para "eliminar" varios registro a la vez --}}
                        <button title="{{trans('book/views.index.delete-massively-button-label')}}"
                                class="btn btn-default btn-sm massively-action bootbox-dialog"
                                role="button"
                                data-toggle="tooltip"
                                data-placement="top"
                                {{-- Setup de ventana modal de confirmación --}}
                                data-modalTitle="{{trans('book/views.index.modal-delete-massively-title')}}"
                                data-modalMessage="{{trans('book/views.index.modal-delete-massively-message')}}"
                                data-btnLabel="{{trans('book/views.index.modal-delete-massively-btn-confirm-label')}}"
                                data-btnClassName="{{trans('book/views.index.modal-delete-massively-btn-confirm-class-name')}}"
                                data-targetFormId="deleteMassivelyForm"
                                type="button">
                            <span class="glyphicon glyphicon-trash"></span>
                            <span class="sr-only">{{trans('book/views.index.delete-massively-button-label')}}</span>
                        </button>
                    
                    {!! Form::close() !!}

                    @endif


                    {{-- Esta opción sólo es mostrada si el usuario decidió consultar los registros "borrados" --}}
                    @if (Request::has('trashed_records'))

                    {{-- Formulario para restablecer resgistros masivamente --}}
                    {!! Form::open(['route' => ['books.restore'], 'method' => 'PUT', 'id' => 'restoreMassivelyForm', 'class' => 'form-inline display-inline']) !!}
                        
                        {{-- Botón que muestra ventana modal de confirmación para el envío del formulario para restablecer varios registros a la vez --}}
                        <button title="{{trans('book/views.index.restore-massively-button-label')}}"
                                class="btn btn-default btn-sm massively-action bootbox-dialog"
                                role="button"
                                data-toggle="tooltip"
                                data-placement="top"
                                {{-- Setup de ventana modal de confirmación --}}
                                data-modalTitle="{{trans('book/views.index.modal-restore-massively-title')}}"
                                data-modalMessage="{{trans('book/views.index.modal-restore-massively-message')}}"
                                data-btnLabel="{{trans('book/views.index.modal-restore-massively-btn-confirm-label')}}"
                                data-btnClassName="{{trans('book/views.index.modal-restore-massively-btn-confirm-class-name')}}"
                                data-targetFormId="restoreMassivelyForm"
                                type="button">
                            <span class="fa fa-mail-reply"></span>
                            <span class="sr-only">{{trans('book/views.index.restore-massively-button-label')}}</span>
                        </button>
                    
                    {!! Form::close() !!}

                    @endif

                        {{-- El boton que dispara la ventana modal con formulario de creación de registro --}}
                        {{--*******************************************************************************************************************************
                            Descomentar este bloque y comentar el bloque siguiente si se desea que el formulario de creación SI quede en la vista del index
                            *******************************************************************************************************************************--}}
                        <div class="display-inline-block" role="button"  data-toggle="tooltip" data-placement="top" title="{{trans('book/views.index.create-button-label')}}">
                            <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#create-form-modal">
                                <span class="glyphicon glyphicon-plus"></span>
                                <span class="sr-only">{{trans('book/views.index.create-button-label')}}</span>
                            </button>
                        </div>

                        {{-- Formulario de creación de registro --}}
                        @include('books.partials.index-create-form')

                        {{-- Link que lleva a la página con el formulario de creación de registro --}}
                        {{--******************************************************************************************************************************
                            Descomentar este bloque y comentar el bloque anterior si se desea que el formulario de creación NO quede en la vista del index
                        <a id="create-books-link" class="btn btn-default btn-sm" href="{!! route('books.create') !!}" role="button"  data-toggle="tooltip" data-placement="top" title="{{trans('book/views.index.create-button-label')}}">
                            <span class="glyphicon glyphicon-plus"></span>
                            <span class="sr-only">{{trans('book/views.index.create-button-label')}}</span>
                        </a>
                            ******************************************************************************************************************************--}}

                    
                    </div>

                    @include('core::partials.notifications')

                </div>

                {{-- La tabla de datos --}}
                @include('books.partials.index-table')

            </div>
        
        </div>    
    
    </section>

@endsection

@section('scripts')

    {{-- Componente Bootstrap-Select, este componente se inicializa automáticamente --}}
    <link href="{{ asset('plugins/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('plugins/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-select/dist/js/i18n/defaults-es_CL.min.js') }}"></script>

    {{-- Componente iCheck --}}
    <link href="{{ asset('plugins/icheck2/square/blue.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/icheck2/square/red.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('plugins/icheck2/icheck.min.js') }}" type="text/javascript"></script>

    {{-- Componente Bootbox --}}
    <script src="{{ asset('plugins/bootbox/bootbox.js') }}" type="text/javascript"></script>

    {{-- Componente Bootstrap DateRangePicker --}}
    <link href="{{ asset('plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('plugins/moment/min/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/bootstrap-daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>

    <script>

        {{-- Inicializa el componente iCheck --}}
        $('.icheckbox_square-blue').icheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue'
        });
        $('.icheckbox_square-red').icheck({
            checkboxClass: 'icheckbox_square-red',
            radioClass: 'iradio_square-red'
        });

        $(document).ready(function(){

            {{-- searching if there are checkboxes checked to toggle enable action buttons --}}
            scanCheckedCheckboxes('.checkbox-table-item');
            
            {{-- toggle the checkbox checked state from row click --}}
            toggleCheckboxFromRowClick();
            
            {{-- toggle select all checkboxes --}}
            toggleCheckboxes();
            
            {{-- listen click on checkboxes to change row class and count the ones checked --}}
            $('.checkbox-table-item').click(function(event) {
                scanCheckedCheckboxes('.'+$(this).attr('class'));
                event.stopPropagation();
            });

        });

        {{-- Previene que se esconda el menú del dropdown al hacer clic a sus elementos hijos --}}
        $('#filters .dropdown-menu input, #filters .dropdown-menu label').click(function(e) {
            e.stopPropagation();
        });

        {{-- Configuración regional para Bootstrap DateRangePicker --}}
        dateRangePickerLocaleSettings = {
            applyLabel: '{!! trans('book/views.index.dateRangePicker.applyLabel') !!}',
            cancelLabel: '{!! trans('book/views.index.dateRangePicker.cancelLabel') !!}',
            fromLabel: '{!! trans('book/views.index.dateRangePicker.fromLabel') !!}',
            toLabel: '{!! trans('book/views.index.dateRangePicker.toLabel') !!}',
            separator: '{!! trans('book/views.index.dateRangePicker.separator') !!}',
            weekLabel: '{!! trans('book/views.index.dateRangePicker.weekLabel') !!}',
            customRangeLabel: '{!! trans('book/views.index.dateRangePicker.customRangeLabel') !!}',
            daysOfWeek: {!! trans('book/views.index.dateRangePicker.daysOfWeek') !!},
            monthNames: {!! trans('book/views.index.dateRangePicker.monthNames') !!},
            firstDay: {!! trans('book/views.index.dateRangePicker.firstDay') !!}
        };

        {{-- Algunos rangos de fecha predeterminados para Bootstrap DateRangePicker --}}
        dateRangePickerRangesSettings = {
            '{!! trans('book/views.index.dateRangePicker.range_today') !!}': [moment(), moment()],
            '{!! trans('book/views.index.dateRangePicker.range_yesterday') !!}': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '{!! trans('book/views.index.dateRangePicker.range_last_7_days') !!}': [moment().subtract(6, 'days'), moment()],
            '{!! trans('book/views.index.dateRangePicker.range_last_30_days') !!}': [moment().subtract(29, 'days'), moment()],
            '{!! trans('book/views.index.dateRangePicker.range_this_month') !!}': [moment().startOf('month'), moment().endOf('month')],
            '{!! trans('book/views.index.dateRangePicker.range_last_month') !!}': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        };

        {{-- Configuración de Bootstrap DateRangePicker --}}
        dateRangePickerLocaleSettings.format = 'YYYY-MM-DD';
        $('input[name="published_year[informative]"]').daterangepicker({
            linkedCalendars: false,
            autoUpdateInput: false,
            autoApply: false,
            opens: 'center',
            locale: dateRangePickerLocaleSettings,
            ranges: dateRangePickerRangesSettings
        });

        dateRangePickerLocaleSettings.format = 'YYYY-MM-DD HH:mm:ss';
        $('input[name="approved_at[informative]"]').daterangepicker({
            linkedCalendars: false,
            format: 'YYYY-MM-DD HH:mm:ss',
            autoUpdateInput: false,
            timePicker: true,
            timePickerIncrement: 1,
            opens: 'left',
            locale: dateRangePickerLocaleSettings,
            ranges: dateRangePickerRangesSettings
        });

        dateRangePickerLocaleSettings.format = 'YYYY-MM-DD HH:mm:ss';
        $('input[name="created_at[informative]"]').daterangepicker({
            linkedCalendars: false,
            format: 'YYYY-MM-DD HH:mm:ss',
            autoUpdateInput: false,
            timePicker: true,
            timePickerIncrement: 1,
            opens: 'left',
            locale: dateRangePickerLocaleSettings,
            ranges: dateRangePickerRangesSettings
        });

        dateRangePickerLocaleSettings.format = 'YYYY-MM-DD HH:mm:ss';
        $('input[name="updated_at[informative]"]').daterangepicker({
            linkedCalendars: false,
            format: 'YYYY-MM-DD HH:mm:ss',
            autoUpdateInput: false,
            timePicker: true,
            timePickerIncrement: 1,
            opens: 'left',
            locale: dateRangePickerLocaleSettings,
            ranges: dateRangePickerRangesSettings
        });

        dateRangePickerLocaleSettings.format = 'YYYY-MM-DD HH:mm:ss';
        $('input[name="deleted_at[informative]"]').daterangepicker({
            linkedCalendars: false,
            format: 'YYYY-MM-DD HH:mm:ss',
            autoUpdateInput: false,
            timePicker: true,
            timePickerIncrement: 1,
            opens: 'left',
            locale: dateRangePickerLocaleSettings,
            ranges: dateRangePickerRangesSettings
        });


        {{-- Las acciones de los eventos apply y cancel de DateRangePicker --}}
        $('input[name$="[informative]"]').on('apply.daterangepicker', function(e, picker) {
            var informativeInputName = $(e.target).attr('name');
            var fromInputName = informativeInputName.replace('informative', 'from');
            var toInputName = informativeInputName.replace('informative', 'to');
            var startDate = picker.startDate.format(picker.locale.format);
            var endDate = picker.endDate.format(picker.locale.format);

            $('input[name="'+fromInputName+'"]').val(startDate);
            $('input[name="'+toInputName+'"]').val(endDate);
            $('input[name="'+informativeInputName+'"]').val(startDate + ' - ' + endDate);
        });

        $('input[name$="[informative]"]').on('cancel.daterangepicker', function(e, picker) {
            var informativeInputName = $(e.target).attr('name');
            var fromInputName = informativeInputName.replace('informative', 'from');
            var toInputName = informativeInputName.replace('informative', 'to');

            $('input[name="'+fromInputName+'"]').val('');
            $('input[name="'+toInputName+'"]').val('');
            $('input[name="'+informativeInputName+'"]').val('');
        });
        
        {{-- Configuración Bootbox, ver mas opciones para el método dialog aquí: https://gist.github.com/makeusabrew/6339780  --}}
        $(document).on("click", ".bootbox-dialog", function(e) {

            // el botón clickeado
            buttonTarget = $(e.currentTarget);
            // el título de la ventana modal
            title = $(e.currentTarget).attr('data-modalTitle');
            // el mensaje a mostrar dentro de la ventana modal
            message = $(e.currentTarget).attr('data-modalMessage');
            // el label del botón de confirmación
            btnLabel = $(e.currentTarget).attr('data-btnLabel');
            // la clase del botón de confirmación
            btnClassName = $(e.currentTarget).attr('data-btnClassName');
            // la clase adicional para la ventana modal
            modalClassName = $(e.currentTarget).attr('data-modalClassName');
            // el formulario al que serán asociados los checkbox de la tabla, si es que se especifica
            targetFormId = $(e.currentTarget).attr('data-targetFormId');

            // título por defecto
            if (!title) {
                title = '{{trans('book/views.index.modal-default-title')}}';
            }

            // label del botón de confirmación por defecto
            if (!btnLabel) {
                btnLabel = '{{trans('book/views.index.modal-default-btn-confirmation-label')}}';
            }

            // clase del botón de confirmación por defecto
            if (!btnClassName) {
                btnClassName = '{{trans('book/views.index.modal-default-btn-confirmation-className')}}';
            }
            
            bootbox.dialog({
                /**
                 * @required String|Element
                 */
                message: message,
                
                /**
                 * @optional String|Element
                 * adds a header to the dialog and places this text in an h4
                 */
                title: title,
                
                /**
                 * @optional String
                 * @default: null
                 * an additional class to apply to the dialog wrapper
                 */
                className: modalClassName,
                
                /**
                 * @optional Object
                 * @default: {}
                 * any buttons shown in the dialog's footer
                 */
                buttons: {
                    // For each key inside the buttons object...
                    
                    /**
                     * @required Object|Function
                     * 
                     * this first usage will ignore the `cancel` key
                     * provided and take all button options from the given object
                     */
                    cancel: {
                        /**
                         * @required String
                         * this button's label
                         */
                        label: '{{trans('book/views.index.modal-default-btn-cancel-label')}}',
                        
                        /**
                         * @optional String
                         * an additional class to apply to the button
                         */
                        className: '{{trans('book/views.index.modal-default-btn-cancel-className')}}',
                        
                        /**
                         * @optional Function
                         * the callback to invoke when this button is clicked
                         */
                        callback: function() {}
                    },

                    /**
                     * @required Object|Function
                     * 
                     * this first usage will ignore the `success` key
                     * provided and take all button options from the given object
                     */
                    success: {
                        /**
                         * @required String
                         * this button's label
                         */
                        label: btnLabel,
                        
                        /**
                         * @optional String
                         * an additional class to apply to the button
                         */
                        className: btnClassName,
                        
                        /**
                         * @optional Function
                         * the callback to invoke when this button is clicked
                         */
                        callback: function() {
                        
                            // si se ha dado algún id de formulario al que deban estar asociados los
                            // checkboxes de la tabla, los asocio a dicho formulario
                            if (targetFormId) {
                                $('.checkbox-table-item').attr('form', targetFormId);
                            }

                            // envíamos el formulario relacionado al botón
                            buttonTarget.closest('form').submit();

                        }
                    }
                }
            });
        });

        {{-- Inicializa el componente BootstrapSwitch --}}
        $(".bootstrap_switch").bootstrapSwitch();

    </script>

    {{-- Componente Bootstrap DateTimePicker --}}
    <link rel="stylesheet" href="{{ asset('plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}"/>
    <script src="{{ asset('plugins/moment/min/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script>

        {{-- Configuración de Bootstrap DateTimePicker --}}
        $('input[name=published_year]').datetimepicker({
            locale: '{{ Lang::locale() }}',
            format: 'YYYY-MM-DD'
        });

    </script>

    {{-- Componente Bootstrap 3 Editable --}}
    <link href="{{ asset('plugins/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('plugins/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- Dependencias de datetimepicker para componente x-editable --}}
    <link href="{{ asset('plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.es.js') }}"></script>

    <script>

        {{-- Configuración del componente x-editable --}}
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $(".editable").editable({ajaxOptions:{method:'PUT'}});

        {{-- Configuración del componente x-editable para el caso de campos de tipo "date" --}}
        $('.editable-date').editable({
            ajaxOptions:{method:'PUT'},
            emptytext: '{{trans('book/views.index.x-editable.dafaultValue')}}',
            format: 'yyyy-mm-dd',
            viewformat: 'dd/mm/yyyy',
            datetimepicker: {
                todayBtn: 'linked',
                weekStart: 1,
                language: 'es'
            }
        });

        {{-- Configuración del componente x-editable para el caso de campos de tipo "datetime" --}}
        $('.editable-datetime').editable({
            ajaxOptions:{method:'PUT'},
            emptytext: '{{trans('book/views.index.x-editable.dafaultValue')}}',
            format: 'yyyy-mm-dd hh:ii:ss',
            viewformat: 'yyyy-mm-dd hh:ii:ss',
            datetimepicker: {
                todayBtn: 'linked',
                weekStart: 1,
                language: 'es'
            }
        });

    </script>

@endsection