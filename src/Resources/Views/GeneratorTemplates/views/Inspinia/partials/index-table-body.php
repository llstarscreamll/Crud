<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
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

    <?= $gen->getViewCopyRightDocBlock() ?>
    
    ****************************************************************************
--}}

@forelse ( $records as $record )
    @if(!isset($hide_checkboxes_column))
    <tr class="item-{{ $record->id }} <?= $gen->hasDeletedAtColumn($fields) ? '{{ $record->trashed() ? \'danger\' : null }}': null ?> ">
    @endif
    <td class="checkbox-column">
        {!! Form::checkbox('id[]', $record->id, null, ['id' => 'record-'.$record->id, 'class' => 'checkbox-table-item']) !!}
    </td>
<?php foreach ($fields as $field) { ?>
<?php if (!$field->hidden) { ?>
        @if(in_array('<?= $field->name ?>', $selectedTableColumns))
        <td class="<?= $field->name ?>">
<?php if (! $gen->isGuarded($field->name)) { ?>
<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// importante dejar el span de del componenten x-editable de la forma en que está <span ...>$record</span> //
// para que no resalte espacios vacíos cuando esté ejecutandose...                                         //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<?php if ($request->get('use_x_editable', false)) { ?>
            @if($record->trashed())
                {{ <?=$gen->getRecordFieldData($field, '$record')?> }}
            @else
                {!! UI::xEditableSpan(
                    '<?=$gen->getInputType($field)?>',
                    '<?=$field->name?>',
                    (string) $record-><?=$field->name?>,
                    (string) <?=$gen->getRecordFieldData($field, '$record')?>,
                    ['data-url' => '/books/'.$record->{$record->getKeyName()}<?php if ($enum_source = $gen->getSourceForEnum($field)) { ?> <?= ', \'data-source\' => '.$enum_source ?><?php } ?>]
                ) !!}
            @endif
<?php } else { ?>
            {{ <?=$gen->getRecordFieldData($field, '$record')?> }}
<?php } ?>
<?php } else { ?>
            {{ <?=$gen->getRecordFieldData($field, '$record')?> }}
<?php } // end if ?>
        </td>
        @endif
<?php } // end if ?>
<?php } // endforeach ?>
        
        @if(!isset($hide_actions_column))
        {{-- Los botones de acción para cada registro --}}
        <td class="actions-column">
<?php if ($gen->hasDeletedAtColumn($fields)) { ?>
        @if ($record->trashed() && auth()->user()->can('<?=$gen->route()?>.restore'))

            {{-- Formulario para restablecer el registro --}}
            {!! Form::open(['route' => ['<?=$gen->route()?>.restore', $record->id], 'method' => 'PUT', 'class' => 'form-inline display-inline']) !!}
                {!! Form::hidden('id[]', $record->id) !!}
                
                {{-- Botón que muestra ventana modal de confirmación para el envío del formulario de restablecer el registro --}}
                <button type="<?= $request->has('use_modal_confirmation_on_delete') ? 'button' : 'submit' ?>"
                        class="btn btn-success btn-xs <?= $request->has('use_modal_confirmation_on_delete') ? 'bootbox-dialog' : null ?>"
                        role="button"
                        data-toggle="tooltip"
                        data-placement="top"
<?php if ($request->has('use_modal_confirmation_on_delete')) { ?>
                        {{-- Setup de ventana modal de confirmación --}}
                        data-modalTitle="{{trans('<?= $gen->solveSharedResourcesNamespace() ?>.modal-restore-title')}}"
                        data-modalMessage="{{trans('<?= $gen->solveSharedResourcesNamespace() ?>.modal-restore-message', ['item' => $record->name])}}"
                        data-btnLabel="{{trans('<?= $gen->solveSharedResourcesNamespace() ?>.modal-restore-btn-confirm')}}"
                        data-btnClassName="btn-success"
<?php } else { ?>
                        onclick="return confirm('{{trans('<?=$gen->getLangAccess()?>.index.restore-confirm-message')}}')"
<?php } ?>
                        title="{{trans('<?= $gen->solveSharedResourcesNamespace() ?>.restore-btn')}}">
                    <span class="fa fa-mail-reply"></span>
                    <span class="sr-only">{{trans('<?= $gen->solveSharedResourcesNamespace() ?>.restore-btn')}}</span>
                </button>
            
            {!! Form::close() !!}

        @else
<?php } ?>
            {{-- Botón para ir a los detalles del registro --}}
            <a  href="{{route('<?=$gen->route()?>.show', $record->id)}}"
                class="btn btn-primary btn-xs"
                role="button"
                data-toggle="tooltip"
                data-placement="top"
                title="{{trans('<?= $gen->solveSharedResourcesNamespace() ?>.show-btn')}}">
                <span class="fa fa-eye"></span>
                <span class="sr-only">{{trans('<?= $gen->solveSharedResourcesNamespace() ?>.show-btn')}}</span>
            </a>

            @if(auth()->user()->can('<?=$gen->route()?>.edit'))
                {{-- Botón para ir a formulario de actualización del registro --}}
                <a  href="{{route('<?=$gen->route()?>.edit', $record->id)}}"
                    class="btn btn-warning btn-xs" role="button"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="{{trans('<?= $gen->solveSharedResourcesNamespace() ?>.edit-btn')}}">
                    <span class="glyphicon glyphicon-pencil"></span>
                    <span class="sr-only">{{trans('<?= $gen->solveSharedResourcesNamespace() ?>.edit-btn')}}</span>
                </a>
            @endif

            @if(auth()->user()->can('<?=$gen->route()?>.destroy'))
                {{-- Formulario para eliminar registro --}}
                {!! Form::open(['route' => ['<?=$gen->route()?>.destroy', $record->id], 'method' => 'DELETE', 'class' => 'form-inline display-inline']) !!}
                    
                    {{-- Botón muestra ventana modal de confirmación para el envío de formulario de eliminar el registro --}}
                    <button type="<?= $request->has('use_modal_confirmation_on_delete') ? 'button' : 'submit' ?>"
                            class="btn btn-danger btn-xs <?= $request->has('use_modal_confirmation_on_delete') ? 'bootbox-dialog' : null ?>"
                            role="button"
                            data-toggle="tooltip"
                            data-placement="top"
<?php if ($request->has('use_modal_confirmation_on_delete')) { ?>
                            {{-- Setup de ventana modal de confirmación --}}
                            data-modalMessage="{{trans('<?= $gen->solveSharedResourcesNamespace() ?>.modal-delete-message', ['item' => $record->name])}}"
                            data-modalTitle="{{trans('<?= $gen->solveSharedResourcesNamespace() ?>.modal-delete-title')}}"
                            data-btnLabel="{{trans('<?= $gen->solveSharedResourcesNamespace() ?>.modal-delete-btn-confirm')}}"
                            data-btnClassName="btn-danger"
<?php } else { ?>
                            onclick="return confirm('{{ trans('<?=$gen->getLangAccess()?>.index.delete-confirm-message') }}')"
<?php } ?>
                            title="{{trans('<?= $gen->solveSharedResourcesNamespace() ?>.trash-btn')}}">
                        <span class="fa fa-trash"></span>
                        <span class="sr-only">{{trans('<?= $gen->solveSharedResourcesNamespace() ?>.trash-btn')}}</span>
                    </button>
                
                {!! Form::close() !!}
            @endif
<?php if ($gen->hasDeletedAtColumn($fields)) { ?>
        @endif
<?php } ?>
        </td>
        @endif
    </tr>

@empty

    <tr>
        <td class="empty-table" colspan="<?=count($fields)+2?>">
            <div  class="alert alert-warning">
                {{trans('<?=$gen->solveSharedResourcesNamespace()?>.no-records-found')}}
            </div>
        </td>
    </tr>

@endforelse