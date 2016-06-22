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
    {{-- Componente Bootstrap 3 Editable --}}
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

<?php if ($gen->hasDateFields($fields) || $gen->hasDateTimeFields($fields)) { ?>
    {{-- Dependencias de datetimepicker para componente x-editable --}}
    <link href="{{ asset('resources/CoreModule/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"></link> 
    <script src="{{ asset('resources/CoreModule/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('resources/CoreModule/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.es.js') }}"></script>
<?php } ?>

<?php if ($gen->hasSelectFields($fields)) { ?>
    {{-- Componente Bootstrap-Select, este componente se inicializa automáticamente --}}
    <script src="{{ asset('resources/CoreModule/bootstrap-select/dist/css/bootstrap-select.min.css') }}"></script>
    <script src="{{ asset('resources/CoreModule/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('resources/CoreModule/bootstrap-select/dist/js/i18n/defaults-es_CL.min.js') }}"></script>
<?php } ?>

    <!-- Componente iCheck -->
    <link href="{{ asset('resources/CoreModule/admin-lte/plugins/iCheck/square/blue.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('resources/CoreModule/admin-lte/plugins/iCheck/square/red.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('resources/CoreModule/admin-lte/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>

<?php if ($request->has('use_modal_confirmation_on_delete')) { ?>
    {{-- Componente Bootbox --}}
    <script src="{{ asset('resources/CoreModule/bootbox/bootbox.js') }}" type="text/javascript"></script>
<?php } ?>

    <script>

<?php if ($request->has('use_modal_confirmation_on_delete')) { ?>
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

            // título por defecto
            if (!title) {
                title = '{{trans('<?=$gen->getLangAccess()?>/views.index.modal-default-title')}}';
            }

            // label del botón de confirmación por defecto
            if (!btnLabel) {
                btnLabel = '{{trans('<?=$gen->getLangAccess()?>/views.index.modal-default-btn-confirmation-label')}}';
            }

            // clase del botón de confirmación por defecto
            if (!btnClassName) {
                btnClassName = '{{trans('<?=$gen->getLangAccess()?>/views.index.modal-default-btn-confirmation-className')}}';
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
                  label: '{{trans('<?=$gen->getLangAccess()?>/views.index.modal-default-btn-cancel-label')}}',
                  
                  /**
                   * @optional String
                   * an additional class to apply to the button
                   */
                  className: '{{trans('<?=$gen->getLangAccess()?>/views.index.modal-default-btn-cancel-className')}}',
                  
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
                    
                    // envíamos el formulario relacionado al botón
                    buttonTarget.closest('form').submit();

                  }
                }
              }
            });

        });
<?php } ?>

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
        {{-- Inicializa el componente BootstrapSwitch --}}
        $(".bootstrap_switch").bootstrapSwitch();

        {{-- Inicializa el componente iCheck --}}
        $('.icheckbox_square-blue').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue'
        });
        $('.icheckbox_square-red').iCheck({
            checkboxClass: 'icheckbox_square-red',
            radioClass: 'iradio_square-red'
        });
<?php } ?>
    </script>
@endsection