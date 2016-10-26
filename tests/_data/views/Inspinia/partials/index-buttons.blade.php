{{--
    ****************************************************************************
    Botones de Index.
    ____________________________________________________________________________
    Muestra los botones o enlaces a acciones como eliminar o crear registros en
    la base dedatos. Esta vista es llamada desde la vista index.
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

<div class="row tools">
    <div class="col-md-6 action-buttons">
    @if (Request::get('trashed_records') != 'onlyTrashed' && auth()->user()->can('books.destroy'))

    {{-- Formulario para borrar resgistros masivamente --}}
    {!! Form::open([
        'route' => ['books.destroy', 0],
        'method' => 'DELETE',
        'id' => 'deleteMassivelyForm',
        'class' => 'form-inline display-inline'
    ]) !!}
        
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
    @if (Request::has('trashed_records') && auth()->user()->can('books.restore'))

    {{-- Formulario para restablecer resgistros masivamente --}}
    {!! Form::open([
        'route' => ['books.restore', 0],
        'method' => 'PUT',
        'id' => 'restoreMassivelyForm',
        'class' => 'form-inline display-inline'
    ]) !!}
        
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

        @if(auth()->user()->can('books.create'))
            {{-- El boton que dispara la ventana modal con formulario de creación de registro --}}
            {{--*******************************************************************************************************************************
                Descomentar este bloque y comentar el bloque siguiente si se desea que el formulario de creación SI quede en la vista del index
                *******************************************************************************************************************************--}}
            <div class="display-inline" role="button"  data-toggle="tooltip" data-placement="top" title="{{trans('book/views.index.create-button-label')}}">
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
        @endif
    </div>

</div>