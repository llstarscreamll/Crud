<?php
namespace CRUD;

use \FunctionalTester;
use Page\Functional\CRUD\Generate as Page;

class GenerateViewsCest
{
    public function _before(FunctionalTester $I)
    {
        new Page($I);
        $I->amLoggedAs(Page::$adminUser);
    }

    public function _after(FunctionalTester $I)
    {
    }

    /**
     * Comprueba las líneas de código generadas en las vistas del CRUD.
     * @param  FunctionalTester $I
     * @return void
     */
    public function checkViewsCode(FunctionalTester $I)
    {
        $I->am('Developer');
        $I->wantTo('revisar las lineas de codigo de las vistas');

        $I->amOnPage('/showOptions?table_name=books');
        $I->see('CrudGenerator', 'h1');

        // envío el formulario de creación del CRUD
        $I->submitForm('form[name=CRUD-form]', Page::$formData);

        //////////////////////////////////////////////
        // código de la vista books/index.blade.php //
        //////////////////////////////////////////////
        $I->openFile('resources/views/books/index.blade.php');

        // veo javascript que previene el comportamiendo por defecto del dropdown para el botón de filtros
        // del formulario de búsqueda
        $I->seeInThisFile("{{-- Previene que se esconda el menú del dropdown al hacer clic a sus elementos hijos --}}
        $('#filters .dropdown-menu input, #filters .dropdown-menu label').click(function(e) {
            e.stopPropagation();
        });");

        // veo llamado a archivos fuente e inicialización de componente Bootstrap DateTimePicker
        // // para los campos de tipo fecha o fecha y hora
        $I->seeInThisFile("{{-- Componente Bootstrap DateTimePicker --}}");
        $I->seeInThisFile("<link rel=\"stylesheet\" href=\"{{ asset('resources/CoreModule/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}\"/>");
        $I->seeInThisFile("<script src=\"{{ asset('resources/CoreModule/moment/min/moment-with-locales.min.js') }}\"></script>");
        $I->seeInThisFile("<script src=\"{{ asset('resources/CoreModule/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}\"></script>");

        // para campos de sólo fecha
        $I->seeInThisFile("$('input[name=published_year]').datetimepicker({
            locale: '{{ Lang::locale() }}',
            format: 'YYYY-MM-DD'
        });");

        // la inclusión de los archivos del componente Bootstrap DateRangePicker
        $I->seeInThisFile("{{-- Componente Bootstrap DateRangePicker --}}");
        $I->seeInThisFile("<link href=\"{{ asset('resources/CoreModule/admin-lte/plugins/daterangepicker/daterangepicker-bs3.css') }}\" rel=\"stylesheet\" type=\"text/css\"/>");
        $I->seeInThisFile("<script src=\"{{ asset('resources/CoreModule/admin-lte/plugins/daterangepicker/moment.min.js') }}\" type=\"text/javascript\"></script>");
        $I->seeInThisFile("<script src=\"{{ asset('resources/CoreModule/admin-lte/plugins/daterangepicker/daterangepicker.js') }}\" type=\"text/javascript\"></script>");

        // veo las configuraciones de inicialización del componente Bootstrap DateRangePicker
        $I->seeInThisFile("{{-- Configuración regional para Bootstrap DateRangePicker --}}
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
        };");

        $I->seeInThisFile("{{-- Configuración de Bootstrap DateRangePicker --}}
        $('input[name=\"published_year[informative]\"]').daterangepicker({
            opens: 'center',
            locale: dateRangePickerLocaleSettings,
            ranges: dateRangePickerRangesSettings
        }, function(start, end, label) {
            $('input[name=\"published_year[from]\"]').val(start.format('YYYY-MM-DD'));
            $('input[name=\"published_year[to]\"]').val(end.format('YYYY-MM-DD'));
        });");

        $I->seeInThisFile("$('input[name=\"created_at[informative]\"]').daterangepicker({
            format: 'MM/DD/YYYY HH:mm:ss',
            timePicker: true,
            timePickerIncrement: 1,
            opens: 'left',
            locale: dateRangePickerLocaleSettings,
            ranges: dateRangePickerRangesSettings
        }, function(start, end, label) {
            $('input[name=\"created_at[from]\"]').val(start.format('YYYY-MM-DD HH:mm:ss'));
            $('input[name=\"created_at[to]\"]').val(end.format('YYYY-MM-DD HH:mm:ss'));
        });");

        // compruebo que el componente del checkbox usado sea el señalado en las opciones
        if (Page::$formData['checkbox_component_on_index_table'] == 'iCheck') {

            // veo los assets del componente
            $I->seeInThisFile("<link href=\"{{ asset('resources/CoreModule/admin-lte/plugins/iCheck/square/blue.css') }}\" rel=\"stylesheet\" type=\"text/css\" />");
            $I->seeInThisFile("<link href=\"{{ asset('resources/CoreModule/admin-lte/plugins/iCheck/square/red.css') }}\" rel=\"stylesheet\" type=\"text/css\" />");
            $I->seeInThisFile("<script src=\"{{ asset('resources/CoreModule/admin-lte/plugins/iCheck/icheck.min.js') }}\" type=\"text/javascript\"></script>");
            
            // veo la inicialización del componente
            $I->seeInThisFile("{{-- Inicializa el componente iCheck --}}
        $('.icheckbox_square-blue').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue'
        });
        $('.icheckbox_square-red').iCheck({
            checkboxClass: 'icheckbox_square-red',
            radioClass: 'iradio_square-red'
        });");

        } else {

            // los assets de BootstrapSwitch son cargados en la plantilla padre, no en este archivo
            // veo la inicialización del componente BootstrapSwitch
            $I->seeInThisFile("{{-- Inicializa el componente BootstrapSwitch --}}
        $(\".bootstrap_switch\").bootstrapSwitch();");

        }

        // compruebo que esté la inicialización del componente x-editable para los respectivos casos
        // para los campos de tipo "date"
        $I->seeInThisFile("$('.editable-date').editable({
            ajaxOptions:{method:'PUT'},
            format: 'yyyy-mm-dd',
            viewformat: 'dd/mm/yyyy',
            datetimepicker: {
                todayBtn: 'linked',
                weekStart: 1,
                language: 'es'
            }
        });");

        // para los campos de tipo "datetime"
        $I->seeInThisFile("$('.editable-datetime').editable({
            ajaxOptions:{method:'PUT'},
            format: 'yyyy-mm-dd hh:ii:ss',
            viewformat: 'yyyy-mm-dd hh:ii:ss',
            datetimepicker: {
                todayBtn: 'linked',
                weekStart: 1,
                language: 'es'
            }
        });");

        // para los demás campos
        $I->seeInThisFile("$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')}});
        $(\".editable\").editable({ajaxOptions:{method:'PUT'}});");

        /////////////////////////////////////////////////////////////
        // código de la vista books/partials/index-table.blade.php //
        /////////////////////////////////////////////////////////////
        $I->openFile('resources/views/books/partials/index-table.blade.php');

        // veo el inicio del tag para el dropdown de mas opciones de filtros para formulario de búsqueda
        $I->seeInThisFile("<div id=\"filters\" class=\"dropdown display-inline\"");
        // veo los campos que indican si se quiere mostrar registros en papelera
        $I->seeInThisFile("{!! Form::radio('trashed_records', 'withTrashed', Request::input('trashed_records') == 'withTrashed' ? true : false, ['form' => 'searchForm']) !!}");
        $I->seeInThisFile("{!! Form::radio('trashed_records', 'onlyTrashed', Request::input('trashed_records') == 'onlyTrashed' ? true : false, ['form' => 'searchForm']) !!}");

        // veo condición que muestra clase CSS de Bootsrtap .danger para registros en papelera
        $I->seeInThisFile("<tr class=\"item-{{ \$record->id }} {{ \$record->trashed() ? 'danger' : null }}\">");

        // veo los campos de búsqueda para fechas correctamente creados, uno informativo,
        // otro para la fecha inicial y otro para la fecha final
        $I->seeInThisFile("{!! Form::input('text', 'published_year[informative]', Request::input('published_year')['informative'], ['form' => 'searchForm', 'class' => 'form-control']) !!}");
        $I->seeInThisFile("{!! Form::input('hidden', 'published_year[from]', Request::input('published_year')['from'], ['form' => 'searchForm']) !!}");
        $I->seeInThisFile("{!! Form::input('hidden', 'published_year[to]', Request::input('published_year')['to'], ['form' => 'searchForm']) !!}");
        

        // compruebo que el componente del checkbox usado sea el señalado en las opciones
        if (Page::$formData['checkbox_component_on_index_table'] == 'iCheck') {
            
            // veo el código de creación de los checkbox acorde al componente iCheck
            $I->seeInThisFile("{!! Form::checkbox('enabled_true', true, Request::input('enabled_true'), ['class' => 'icheckbox_square-blue', 'form' => 'searchForm']) !!}");

        } elseif (Page::$formData['checkbox_component_on_index_table'] == 'BootstrapSwitch') {

            // veo el código de creación de los checkbox acorde al componente BootstrapSwitch
            $I->seeInThisFile("{!! Form::checkbox('enabled_true', true, Request::input('enabled_true'),
                    [
                    'class' => 'bootstrap_switch',
                    'data-size' => 'mini',
                    'data-on-text' => 'Si',
                    'data-off-text' => '-',
                    'data-on-color' => 'primary',
                    'data-off-color' => 'default',
                    isset(\$show) ? 'disabled' : '',
                    'form' => 'searchForm'
                    ]
                ) !!}");
        }

        $I->seeInThisFile('<span @if (! $record->trashed()) class="editable"
                          data-type="select"
                          data-name="reason_id"
                          data-placement="bottom"
                          data-value="{{ $record->reason_id }}"
                          data-pk="{{ $record->{$record->getKeyName()} }}"
                          data-url="/books/{{ $record->{$record->getKeyName()} }}"
                          data-source=\'{!! $reason_id_list_json !!}\'
                          @endif>{{ $record->reason ? $record->reason->name : \'\' }}</span>');

        $I->seeInThisFile('<span @if (! $record->trashed()) class="editable"
                          data-type="select"
                          data-name="status"
                          data-placement="bottom"
                          data-value="{{ $record->status }}"
                          data-pk="{{ $record->{$record->getKeyName()} }}"
                          data-url="/books/{{ $record->{$record->getKeyName()} }}"
                          data-source=\'{!! $status_list_json !!}\'
                          @endif>{{ $record->status }}</span>');

        // los campos con atributo hidden no deben aparecer en la tabla del index
        $I->dontSeeInThisFile("<a href=\"{{route('books.index',
                        array_merge(
                            Request::query(),
                            [
                            'sort' => 'approved_password',
                            'sortType' => (Request::input('sort') == 'approved_password' and Request::input('sortType') == 'asc') ? 'desc' : 'asc'
                            ]
                        )
                    )}}\">");

        /////////////////////////////////////////////////////////////
        // código de la vista books/partials/form-fields.blade.php //
        /////////////////////////////////////////////////////////////
        $I->openFile('resources/views/books/partials/form-fields.blade.php');
        // los siguientes campos no deben estar en la vista, como se especificó en el formulario
        $I->dontSeeInThisFile("{!! Form::input('text', 'approved_at', null, ['class' => 'form-control', isset(\$show) ? 'disabled' : '']) !!}");
        $I->dontSeeInThisFile("{!! Form::select('approved_by', \$approved_by_list, null, ['class' => 'form-control', isset(\$show) ? 'disabled' : '']) !!}");

        // el siguiente campo debe tener otro campo de comprobación, como las constraseñas
        // NOTA: es importante dejar la identación como está!!
        $I->seeInThisFile("@if(!isset(\$show))");
        $I->seeInThisFile("<div class='form-group col-sm-6 {{\$errors->has('unlocking_word') ? 'has-error' : ''}}'>");
        $I->seeInThisFile("{!! Form::label('unlocking_word_confirmation', trans('book/views.form-fields.unlocking_word_confirmation')) !!}");
        $I->seeInThisFile("{!! Form::input('text', 'unlocking_word_confirmation', null, ['class' => 'form-control']) !!}");
        $I->seeInThisFile("{!!\$errors->first('unlocking_word', '<span class=\"text-danger\">:message</span>')!!}");
        $I->seeInThisFile("</div>");
        $I->seeInThisFile("@endif");

        ////////////////////////////////////////////////////////////////////
        // código de la vista books/partials/hidden-form-fields.blade.php //
        ////////////////////////////////////////////////////////////////////
        $I->openFile('resources/views/books/partials/hidden-form-fields.blade.php');

        // veo que los select generados usan el componente BootstrapSelect
        $I->seeInThisFile("{!! Form::select('approved_by', ['' => '---']+\$approved_by_list, null, ['class' => 'form-control selectpicker', isset(\$show) ? 'disabled' : null]) !!}");

        /////////////////////////////////////////////
        // código de la vista books/show.blade.php //
        /////////////////////////////////////////////
        $I->openFile('resources/views/books/show.blade.php');

        // veo el campo id en modo disabled
        $I->seeInThisFile("{!! Form::input('text', 'id', null, ['class' => 'form-control', isset(\$show) ? 'disabled' : '']) !!}");

        // veo las dependencias del componente BootstrapSelect
        $I->seeInThisFile("<script src=\"{{ asset('resources/CoreModule/bootstrap-select/dist/css/bootstrap-select.min.css') }}\"></script>");
        $I->seeInThisFile("<script src=\"{{ asset('resources/CoreModule/bootstrap-select/dist/js/bootstrap-select.min.js') }}\"></script>");
        $I->seeInThisFile("<script src=\"{{ asset('resources/CoreModule/bootstrap-select/dist/js/i18n/defaults-es_CL.min.js') }}\"></script>");

        ///////////////////////////////////////////////
        // código de la vista books/create.blade.php //
        ///////////////////////////////////////////////
        $I->openFile('resources/views/books/create.blade.php');

        // veo llamado a archivos fuente e inicialización de componente Bootstrap DateTimePicker
        // // para los campos de tipo fecha o fecha y hora
        $I->seeInThisFile("{{-- Componente Bootstrap DateTimePicker --}}");
        $I->seeInThisFile("<link rel=\"stylesheet\" href=\"{{ asset('resources/CoreModule/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}\"/>");
        $I->seeInThisFile("<script src=\"{{ asset('resources/CoreModule/moment/min/moment-with-locales.min.js') }}\"></script>");
        $I->seeInThisFile("<script src=\"{{ asset('resources/CoreModule/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}\"></script>");

        // para campos de sólo fecha
        $I->seeInThisFile("$('input[name=published_year]').datetimepicker({
            locale: '{{ Lang::locale() }}',
            format: 'YYYY-MM-DD'
        });");

        //////////////////////////////////////////////
        // código de la vista books/edit.blade.php //
        /////////////////////////////////////////////
        $I->openFile('resources/views/books/edit.blade.php');

        // veo llamado a archivos fuente e inicialización de componente Bootstrap DateTimePicker
        // para los campos de tipo fecha o fecha y hora
        $I->seeInThisFile("{{-- Componente Bootstrap DateTimePicker --}}");
        $I->seeInThisFile("<link rel=\"stylesheet\" href=\"{{ asset('resources/CoreModule/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}\"/>");
        $I->seeInThisFile("<script src=\"{{ asset('resources/CoreModule/moment/min/moment-with-locales.min.js') }}\"></script>");
        $I->seeInThisFile("<script src=\"{{ asset('resources/CoreModule/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}\"></script>");

        // para campos de sólo fecha
        $I->seeInThisFile("$('input[name=published_year]').datetimepicker({
            locale: '{{ Lang::locale() }}',
            format: 'YYYY-MM-DD'
        });");
    }
}
