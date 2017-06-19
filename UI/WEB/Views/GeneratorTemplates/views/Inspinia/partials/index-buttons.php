{{--
    ****************************************************************************
    Botones de Index.
    ____________________________________________________________________________
    Muestra los botones o enlaces a acciones como eliminar o crear registros en
    la base dedatos. Esta vista es llamada desde la vista index.
    ****************************************************************************

    <?= $crud->getViewCopyRightDocBlock() ?>
    
    ****************************************************************************
--}}

<div class="row tools">
    <div class="col-md-6 action-buttons">
<?php
///////////////////////////////////////////////////////////
// creamos formulario para eliminar registros masivamete //
///////////////////////////////////////////////////////////
?>
    @if (array_get(Request::get(<?= $crud->getSearchFieldsPrefixConfigString() ?>), 'trashed_records', null) != 'onlyTrashed' && auth()->user()->can('<?=$crud->route()?>.destroy'))

    {{-- Formulario para borrar resgistros masivamente --}}
    {!! Form::open([
        'route' => ['<?=$crud->route()?>.destroy', 0],
        'method' => 'DELETE',
        'id' => 'deletemanyForm',
        'class' => 'form-inline display-inline'
    ]) !!}
        
        {{-- Botón que muestra ventana modal de confirmación para el envío del formulario para <?= strtolower($crud->getDestroyBtnTxt()) ?> varios registro a la vez --}}
        <button title="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.<?= $crud->getDestroyVariableName() ?>-many-btn')}}"
                class="btn btn-default btn-sm many-action <?= $request->has('use_modal_confirmation_on_delete') ? 'bootbox-dialog' : null ?>"
                role="button"
                data-toggle="tooltip"
                data-placement="top"
<?php if ($request->has('use_modal_confirmation_on_delete')) { ?>
                {{-- Setup de ventana modal de confirmación --}}
                data-modalTitle="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.<?= $crud->getDestroyVariableName() ?>-btn')}}"
                data-modalMessage="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.modal-<?= $crud->getDestroyVariableName() ?>-many-message')}}"
                data-btnLabel="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.modal-<?= $crud->getDestroyVariableName() ?>-many-btn-confirm')}}"
                data-btnClassName="btn-danger"
                data-targetFormId="deletemanyForm"
<?php } else { ?>
                onclick="return confirm('{{trans('<?=$crud->getLangAccess()?>.index.delete-many-confirm-message')}}')"
<?php } ?>
                type="<?= $request->has('use_modal_confirmation_on_delete') ? 'button' : 'submit' ?>">
            <span class="fa fa-<?= $crud->getDestroyVariableName() == 'trash' ? 'trash' : 'minus-circle' ?>"></span>
            <span class="sr-only">{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.<?= $crud->getDestroyVariableName() ?>-many-btn')}}</span>
        </button>
    
    {!! Form::close() !!}

    @endif

<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Si la entidad tiene softDeletes podemos añadir la opción de restaurar los registros "borrados" masivamente //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<?php if ($crud->hasDeletedAtColumn($fields)) { ?>

    {{-- Esta opción sólo es mostrada si el usuario decidió consultar los registros "borrados" --}}
    @if (array_get(Request::get(<?= $crud->getSearchFieldsPrefixConfigString() ?>), 'trashed_records', null) && auth()->user()->can('<?=$crud->route()?>.restore'))

    {{-- Formulario para restablecer resgistros masivamente --}}
    {!! Form::open([
        'route' => ['<?=$crud->route()?>.restore', 0],
        'method' => 'PUT',
        'id' => 'restoremanyForm',
        'class' => 'form-inline display-inline'
    ]) !!}
        
        {{-- Botón que muestra ventana modal de confirmación para el envío del formulario para restablecer varios registros a la vez --}}
        <button title="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.restore-many-btn')}}"
                class="btn btn-default btn-sm many-action <?= $request->has('use_modal_confirmation_on_delete') ? 'bootbox-dialog' : null ?>"
                role="button"
                data-toggle="tooltip"
                data-placement="top"
<?php if ($request->has('use_modal_confirmation_on_delete')) { ?>
                {{-- Setup de ventana modal de confirmación --}}
                data-modalTitle="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.modal-restore-many-title')}}"
                data-modalMessage="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.modal-restore-many-message')}}"
                data-btnLabel="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.modal-restore-many-btn-confirm')}}"
                data-btnClassName="btn-success"
                data-targetFormId="restoremanyForm"
<?php } else { ?>
                onclick="return confirm('{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.restore-many-confirm-message')}}')"
<?php } ?>
                type="<?= $request->has('use_modal_confirmation_on_delete') ? 'button' : 'submit' ?>">
            <span class="fa fa-mail-reply"></span>
            <span class="sr-only">{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.restore-many-btn')}}</span>
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
        @if(auth()->user()->can('<?=$crud->route()?>.create'))
            {{-- El boton que dispara la ventana modal con formulario de creación de registro --}}
            {{--*******************************************************************************************************************************
                Descomentar este bloque y comentar el bloque siguiente si se desea que el formulario de creación SI quede en la vista del index
                *******************************************************************************************************************************--}}
            <div class="display-inline" role="button"  data-toggle="tooltip" data-placement="top" title="{{trans('<?=$crud->getLangAccess()?>.index-create-btn')}}">
                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#create-form-modal">
                    <span class="glyphicon glyphicon-plus"></span>
                    <span class="sr-only">{{trans('<?=$crud->getLangAccess()?>.index-create-btn')}}</span>
                </button>
            </div>

            {{-- Formulario de creación de registro --}}
            @include('<?=$crud->viewsDirName()?>.partials.index-create-form')

            {{-- Link que lleva a la página con el formulario de creación de registro --}}
            {{--******************************************************************************************************************************
                Descomentar este bloque y comentar el bloque anterior si se desea que el formulario de creación NO quede en la vista del index
            <a id="create-<?=$crud->route()?>-link" class="btn btn-default btn-sm" href="{!! route('<?=$crud->route()?>.create') !!}" role="button"  data-toggle="tooltip" data-placement="top" title="{{trans('<?=$crud->getLangAccess()?>.index-create-btn')}}">
                <span class="glyphicon glyphicon-plus"></span>
                <span class="sr-only">{{trans('<?=$crud->getLangAccess()?>.index-create-btn')}}</span>
            </a>
                ******************************************************************************************************************************--}}
        @endif
    </div>
</div>