<?php
/* @var $crud App\Containers\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
{{--
    ****************************************************************************
    El cuerpo de la tabla.
    ____________________________________________________________________________
    Aquí se muestran los datos devueltos por la consulta ejecutada en el
    controlador según los criterios que haya dado el usuario.

    En caso de que se desee reutilizar esta vista y esconder la columna de los
    checkbox, al llamar esta vista enviar la variable:
    $hide_checkboxes_column = true

    Si se desea ocultar la columna de acciones, al llamar la vista enviar la
    variable:
    $hide_actions_column = true
    ****************************************************************************

    <?= $crud->getViewCopyRightDocBlock() ?>
    
    ****************************************************************************
--}}

@forelse ( $records as $record )
    @if(!isset($hide_checkboxes_column))
    <tr class="item-{{ $record->id }} <?= $crud->hasDeletedAtColumn($fields) ? '{{ $record->trashed() ? \'danger\' : null }}': null ?> ">
    @endif
    <td class="checkbox-column">
        {!! Form::checkbox('id[]', $record->id, null, ['id' => 'record-'.$record->id, 'class' => 'checkbox-table-item']) !!}
    </td>
<?php foreach ($fields as $field) { ?>
<?php if (!$field->hidden) { ?>
        @if(in_array('<?= $field->name ?>', $selectedTableColumns))
        <td class="<?= $field->name ?>">
<?php if (! $crud->isGuarded($field->name)) { ?>
<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// importante dejar el span de del componenten x-editable de la forma en que está <span ...>$record</span> //
// para que no resalte espacios vacíos cuando esté ejecutandose...                                         //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<?php if ($request->get('use_x_editable', false)) { ?>
            @if($record->trashed())
                {{ <?=$crud->getRecordFieldData($field, '$record')?> }}
            @else
                {!! UISearch::xEditableSpan(
                    '<?=$crud->getInputType($field)?>',
                    '<?=$field->name?>',
                    (string) $record-><?=$field->name?>,
                    (string) <?=$crud->getRecordFieldData($field, '$record')?>,
                    ['data-url' => '/<?=$crud->route()?>/'.$record->{$record->getKeyName()}<?php if ($enum_source = $crud->getSourceForEnum($field)) { ?> <?= ', \'data-source\' => '.$enum_source ?><?php } ?>]
                ) !!}
            @endif
<?php } else { ?>
            {{ <?=$crud->getRecordFieldData($field, '$record')?> }}
<?php } ?>
<?php } else { ?>
            {{ <?=$crud->getRecordFieldData($field, '$record')?> }}
<?php } // end if ?>
        </td>
        @endif
<?php } // end if ?>
<?php } // endforeach ?>
        
        @if(!isset($hide_actions_column))
        {{-- Los botones de acción para cada registro --}}
        <td class="actions-column">
<?php if ($crud->hasDeletedAtColumn($fields)) { ?>
        @if ($record->trashed() && auth()->user()->can('<?=$crud->route()?>.restore'))

            {{-- Formulario para restablecer el registro --}}
            {!! Form::open(['route' => ['<?=$crud->route()?>.restore', $record->id], 'method' => 'PUT', 'class' => 'form-inline display-inline']) !!}
                {!! Form::hidden('id[]', $record->id) !!}
                
                {{-- Botón que muestra ventana modal de confirmación para el envío del formulario de restablecer el registro --}}
                <button type="<?= $request->has('use_modal_confirmation_on_delete') ? 'button' : 'submit' ?>"
                        class="btn btn-success btn-xs <?= $request->has('use_modal_confirmation_on_delete') ? 'bootbox-dialog' : null ?>"
                        role="button"
                        data-toggle="tooltip"
                        data-placement="top"
<?php if ($request->has('use_modal_confirmation_on_delete')) { ?>
                        {{-- Setup de ventana modal de confirmación --}}
                        data-modalTitle="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.modal-restore-title')}}"
                        data-modalMessage="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.modal-restore-message', ['item' => $record->name])}}"
                        data-btnLabel="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.modal-restore-btn-confirm')}}"
                        data-btnClassName="btn-success"
<?php } else { ?>
                        onclick="return confirm('{{trans('<?=$crud->getLangAccess()?>.index.restore-confirm-message')}}')"
<?php } ?>
                        title="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.restore-btn')}}">
                    <span class="fa fa-mail-reply"></span>
                    <span class="sr-only">{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.restore-btn')}}</span>
                </button>
            
            {!! Form::close() !!}

        @else
<?php } ?>
            {{-- Botón para ir a los detalles del registro --}}
            <a  href="{{route('<?=$crud->route()?>.show', $record->id)}}"
                class="btn btn-primary btn-xs"
                role="button"
                data-toggle="tooltip"
                data-placement="top"
                title="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.show-btn')}}">
                <span class="fa fa-eye"></span>
                <span class="sr-only">{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.show-btn')}}</span>
            </a>

            @if(auth()->user()->can('<?=$crud->route()?>.edit'))
                {{-- Botón para ir a formulario de actualización del registro --}}
                <a  href="{{route('<?=$crud->route()?>.edit', $record->id)}}"
                    class="btn btn-warning btn-xs" role="button"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.edit-btn')}}">
                    <span class="glyphicon glyphicon-pencil"></span>
                    <span class="sr-only">{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.edit-btn')}}</span>
                </a>
            @endif

            @if(auth()->user()->can('<?=$crud->route()?>.destroy'))
                {{-- Formulario para <?= strtolower($crud->getDestroyBtnTxt()) ?> registro --}}
                {!! Form::open(['route' => ['<?=$crud->route()?>.destroy', $record->id], 'method' => 'DELETE', 'class' => 'form-inline display-inline']) !!}
                    
                    {{-- Botón muestra ventana modal de confirmación para el envío de formulario de eliminar el registro --}}
                    <button type="<?= $request->has('use_modal_confirmation_on_delete') ? 'button' : 'submit' ?>"
                            class="btn btn-danger btn-xs <?= $request->has('use_modal_confirmation_on_delete') ? 'bootbox-dialog' : null ?>"
                            role="button"
                            data-toggle="tooltip"
                            data-placement="top"
<?php if ($request->has('use_modal_confirmation_on_delete')) { ?>
                            {{-- Setup de ventana modal de confirmación --}}
                            data-modalMessage="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.modal-<?= $crud->getDestroyVariableName() ?>-message', ['item' => $record->name])}}"
                            data-modalTitle="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.modal-<?= $crud->getDestroyVariableName() ?>-title')}}"
                            data-btnLabel="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.modal-<?= $crud->getDestroyVariableName() ?>-btn-confirm')}}"
                            data-btnClassName="btn-danger"
<?php } else { ?>
                            onclick="return confirm('{{ trans('<?=$crud->getLangAccess()?>.index.<?= $crud->getDestroyVariableName() ?>-confirm-message') }}')"
<?php } ?>
                            title="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.<?= $crud->getDestroyVariableName() ?>-btn')}}">
                        <span class="fa fa-<?= $crud->getDestroyVariableName() == 'trash' ? 'trash' : 'minus-circle' ?>"></span>
                        <span class="sr-only">{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.<?= $crud->getDestroyVariableName() ?>-btn')}}</span>
                    </button>
                
                {!! Form::close() !!}
            @endif
<?php if ($crud->hasDeletedAtColumn($fields)) { ?>
        @endif
<?php } ?>
        </td>
        @endif
    </tr>

@empty

    <tr>
        <td class="empty-table" colspan="<?=count($fields)+2?>">
            <div  class="alert alert-warning">
                {{trans('<?=$crud->solveSharedResourcesNamespace()?>.no-records-found')}}
            </div>
        </td>
    </tr>

@endforelse