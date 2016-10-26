{{--
    ****************************************************************************
    Botones de Index.
    ____________________________________________________________________________
    Muestra los botones o enlaces a acciones como eliminar o crear registros en
    la base dedatos. Esta vista es llamada desde la vista index.
    ****************************************************************************

    <?= $gen->getViewCopyRightDocBlock() ?>
    
    ****************************************************************************
--}}

<div class="row tools">
    <div class="col-md-6 action-buttons">
<?php
///////////////////////////////////////////////////////////
// creamos formulario para eliminar registros masivamete //
///////////////////////////////////////////////////////////
?>
    @if (Request::get('trashed_records') != 'onlyTrashed' && auth()->user()->can('<?=$gen->route()?>.destroy'))

    {{-- Formulario para borrar resgistros masivamente --}}
    {!! Form::open([
        'route' => ['<?=$gen->route()?>.destroy', 0],
        'method' => 'DELETE',
        'id' => 'deleteMassivelyForm',
        'class' => 'form-inline display-inline'
    ]) !!}
        
        {{-- Botón que muestra ventana modal de confirmación para el envío del formulario para "eliminar" varios registro a la vez --}}
        <button title="{{trans('<?=$gen->getLangAccess()?>/views.index.delete-massively-button-label')}}"
                class="btn btn-default btn-sm massively-action <?= $request->has('use_modal_confirmation_on_delete') ? 'bootbox-dialog' : null ?>"
                role="button"
                data-toggle="tooltip"
                data-placement="top"
<?php if ($request->has('use_modal_confirmation_on_delete')) { ?>
                {{-- Setup de ventana modal de confirmación --}}
                data-modalTitle="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-delete-massively-title')}}"
                data-modalMessage="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-delete-massively-message')}}"
                data-btnLabel="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-delete-massively-btn-confirm-label')}}"
                data-btnClassName="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-delete-massively-btn-confirm-class-name')}}"
                data-targetFormId="deleteMassivelyForm"
<?php } else { ?>
                onclick="return confirm('{{trans('<?=$gen->getLangAccess()?>/views.index.delete-massively-confirm-message')}}')"
<?php } ?>
                type="<?= $request->has('use_modal_confirmation_on_delete') ? 'button' : 'submit' ?>">
            <span class="glyphicon glyphicon-trash"></span>
            <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.delete-massively-button-label')}}</span>
        </button>
    
    {!! Form::close() !!}

    @endif

<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Si la entidad tiene softDeletes podemos añadir la opción de restaurar los registros "borrados" masivamente //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<?php if ($gen->hasDeletedAtColumn($fields)) { ?>

    {{-- Esta opción sólo es mostrada si el usuario decidió consultar los registros "borrados" --}}
    @if (Request::has('trashed_records') && auth()->user()->can('<?=$gen->route()?>.restore'))

    {{-- Formulario para restablecer resgistros masivamente --}}
    {!! Form::open([
        'route' => ['<?=$gen->route()?>.restore', 0],
        'method' => 'PUT',
        'id' => 'restoreMassivelyForm',
        'class' => 'form-inline display-inline'
    ]) !!}
        
        {{-- Botón que muestra ventana modal de confirmación para el envío del formulario para restablecer varios registros a la vez --}}
        <button title="{{trans('<?=$gen->getLangAccess()?>/views.index.restore-massively-button-label')}}"
                class="btn btn-default btn-sm massively-action <?= $request->has('use_modal_confirmation_on_delete') ? 'bootbox-dialog' : null ?>"
                role="button"
                data-toggle="tooltip"
                data-placement="top"
<?php if ($request->has('use_modal_confirmation_on_delete')) { ?>
                {{-- Setup de ventana modal de confirmación --}}
                data-modalTitle="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-restore-massively-title')}}"
                data-modalMessage="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-restore-massively-message')}}"
                data-btnLabel="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-restore-massively-btn-confirm-label')}}"
                data-btnClassName="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-restore-massively-btn-confirm-class-name')}}"
                data-targetFormId="restoreMassivelyForm"
<?php } else { ?>
                onclick="return confirm('{{trans('<?=$gen->getLangAccess()?>/views.index.restore-massively-confirm-message')}}')"
<?php } ?>
                type="<?= $request->has('use_modal_confirmation_on_delete') ? 'button' : 'submit' ?>">
            <span class="fa fa-mail-reply"></span>
            <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.restore-massively-button-label')}}</span>
        </button>
    
    {!! Form::close() !!}

    @endif
<?php } ?>

<?php
///////////////////////////////////////////////////////////////////////////////////////////////////
// el formulario de creación en el index a través de una ventana modal puede ser habilitado o    //
// deshabilitado por el desarrollado comentando las lineas correspondientes, si se quiere que    //
// el formulario de creación quede en el index, dejar el siguiente bloque y comentar el link,    //
// viceversa para quitar el formulario del index y habilitar link para redirección a ruta create //
///////////////////////////////////////////////////////////////////////////////////////////////////
?>
        @if(auth()->user()->can('<?=$gen->route()?>.create'))
            {{-- El boton que dispara la ventana modal con formulario de creación de registro --}}
            {{--*******************************************************************************************************************************
                Descomentar este bloque y comentar el bloque siguiente si se desea que el formulario de creación SI quede en la vista del index
                *******************************************************************************************************************************--}}
            <div class="display-inline" role="button"  data-toggle="tooltip" data-placement="top" title="{{trans('<?=$gen->getLangAccess()?>/views.index.create-button-label')}}">
                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#create-form-modal">
                    <span class="glyphicon glyphicon-plus"></span>
                    <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.create-button-label')}}</span>
                </button>
            </div>

            {{-- Formulario de creación de registro --}}
            @include('<?=$gen->viewsDirName()?>.partials.index-create-form')

            {{-- Link que lleva a la página con el formulario de creación de registro --}}
            {{--******************************************************************************************************************************
                Descomentar este bloque y comentar el bloque anterior si se desea que el formulario de creación NO quede en la vista del index
            <a id="create-<?=$gen->route()?>-link" class="btn btn-default btn-sm" href="{!! route('<?=$gen->route()?>.create') !!}" role="button"  data-toggle="tooltip" data-placement="top" title="{{trans('<?=$gen->getLangAccess()?>/views.index.create-button-label')}}">
                <span class="glyphicon glyphicon-plus"></span>
                <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.create-button-label')}}</span>
            </a>
                ******************************************************************************************************************************--}}
        @endif
    </div>

</div>