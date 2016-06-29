<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>

{!! Form::open(['route' => '<?=$gen->route()?>.index', 'method' => 'GET', 'id' => 'searchForm']) !!}
{!! Form::close() !!}

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            {{-- Nombres de columnas de tabla --}}
            <tr class="header-row">
                <td></td>
<?php foreach ($fields as $field) { ?>
<?php if (!$field->hidden) { ?>
                <th>
                    <a href="{{route('<?=$gen->route()?>.index',
                        array_merge(
                            Request::query(),
                            [
                            'sort' => '<?=$field->name?>',
                            'sortType' => (Request::input('sort') == '<?=$field->name?>' and Request::input('sortType') == 'asc') ? 'desc' : 'asc'
                            ]
                        )
                    )}}">
                        {{trans('<?=$gen->getLangAccess()?>/views.form-fields-short-name.<?=$field->name?>')}}
                        {!!Request::input('sort') == '<?=$field->name?>' ? '<i class="fa fa-sort-alpha-'.Request::input('sortType').'"></i>' : ''!!}
                    </a>
                </th>
<?php } ?>
<?php } ?>
                <th>{{trans('<?=$gen->getLangAccess()?>/views.index.table-actions-column')}}</th>
            </tr>
            
            {{-- Elementos de Formulario de búqueda de tabla --}}
            <tr class="search-row">

                <td>{!! Form::checkbox('check_all', 'check_all', null, ['id' => 'check_all']) !!}</td>
<?php foreach ($fields as $field) { ?>
<?php if (!$field->hidden) { ?>
                <td><?=$gen->getSearchInputStr($field, $gen->table_name)?></td>
<?php } ?>
<?php } ?>

                {{-- Los botones de búsqueda y limpieza del formulario --}}
                <td style="min-width: 8em;">

                    {{-- Más opciones de filtros --}}
                    <div id="filters" class="dropdown display-inline"
                         data-toggle="tooltip"
                         data-placement="top"
                         title="{{ trans('<?=$gen->getLangAccess()?>/views.index.filters-button-label') }}">
                        <button class="btn btn-default btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <span class="sr-only">{{ trans('<?=$gen->getLangAccess()?>/views.index.filters-button-label') }}</span>
                            <span class="glyphicon glyphicon-filter"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                            <li class="dropdown-header">{{ trans('<?=$gen->getLangAccess()?>/views.index.filters-button-label') }}</li>
                            <li role="separator" class="divider"></li>
<?php if ($gen->hasDeletedAtColumn($fields)) { ?>
                            <li>
                                <div class="checkbox">
                                    <label>
                                        {!! Form::radio('trashed_records', 'withTrashed', Request::input('trashed_records') == 'withTrashed' ? true : false, ['form' => 'searchForm']) !!} {{ trans('<?=$gen->getLangAccess()?>/views.index.filter-with-trashed-label') }}
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox">
                                    <label>
                                        {!! Form::radio('trashed_records', 'onlyTrashed', Request::input('trashed_records') == 'onlyTrashed' ? true : false, ['form' => 'searchForm']) !!} {{ trans('<?=$gen->getLangAccess()?>/views.index.filter-only-trashed-label') }}
                                    </label>
                                </div>
                            </li>
<?php } ?>
                        </ul>
                    </div>
                    
                    <button type="submit"
                            form="searchForm"
                            class="btn btn-primary btn-xs"
                            data-toggle="tooltip"
                            data-placement="top"
                            title="{{trans('<?=$gen->getLangAccess()?>/views.index.search-button-label')}}">
                        <span class="fa fa-search"></span>
                        <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.search-button-label')}}</span>
                    </button>

                    <a  href="{{route('<?=$gen->route()?>.index')}}"
                        class="btn btn-danger btn-xs"
                        role="button"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="{{trans('<?=$gen->getLangAccess()?>/views.index.clean-filter-button-label')}}">
                        <span class="glyphicon glyphicon-remove"></span>
                        <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.clean-filter-button-label')}}</span>
                    </a>

                </td>

            </tr>
        </thead>

        <tbody>

            @forelse ( $records as $record )
            <tr class="item-{{ $record->id }} {{ $record->trashed() ? 'danger' : null }}">
            <td>{!! Form::checkbox('id[]', $record->id, null, ['id' => 'record-'.$record->id, 'class' => 'checkbox-table-item']) !!}</td>
<?php foreach ($fields as $field) { ?>
<?php if (!$field->hidden) { ?>
                <td>
<?php if (! $gen->isGuarded($field->name)) { ?>
                    {{-- Campo editable --}}
                    <span @if (! $record->trashed()) class="<?=$gen->getInputXEditableClass($field)?>"
                          data-type="<?=$gen->getInputType($field)?>"
                          data-name="<?=$field->name?>"
                          data-placement="bottom"
                          data-value="{{ $record-><?=$field->name?> }}"
                          data-pk="{{ $record->{$record->getKeyName()} }}"
                          data-url="/<?=$gen->route()?>/{{ $record->{$record->getKeyName()} }}"
                          <?=$gen->getSourceForEnum($field)?> @endif>{{ <?=$gen->getRecordFieldData($field, '$record')?> }}</span>
<?php } else { ?>
                    {{-- Los campos protejidos no son editables --}}
                    {{ <?=$gen->getRecordFieldData($field, '$record')?> }}
<?php } // end if ?>
                </td>
<?php } // end if ?>
<?php } // endforeach ?>
                
                {{-- Los botones de acción para cada registro --}}
                <td class="actions-cell">
<?php if ($gen->hasDeletedAtColumn($fields)) { ?>
                @if ($record->trashed())

                    {{-- Formulario para restablecer el registro --}}
                    {!! Form::open(['route' => ['<?=$gen->route()?>.restore'], 'method' => 'PUT', 'class' => 'form-inline display-inline']) !!}

                        {!! Form::hidden('id[]', $record->id) !!}
                        
                        {{-- Botón que muestra ventana modal de confirmación para el envío del formulario de restablecer el registro --}}
                        <button type="<?= $request->has('use_modal_confirmation_on_delete') ? 'button' : 'submit' ?>"
                                class="btn btn-success btn-xs <?= $request->has('use_modal_confirmation_on_delete') ? 'bootbox-dialog' : null ?>"
                                role="button"
                                data-toggle="tooltip"
                                data-placement="top"
<?php if ($request->has('use_modal_confirmation_on_delete')) { ?>
                                {{-- Setup de ventana modal de confirmación --}}
                                data-modalTitle="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-restore-title')}}"
                                data-modalMessage="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-restore-message', ['item' => $record->name])}}"
                                data-btnLabel="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-restore-btn-confirm-label')}}"
                                data-btnClassName="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-restore-btn-confirm-class-name')}}"
<?php } else { ?>
                                onclick="return confirm('{{trans('<?=$gen->getLangAccess()?>/views.index.restore-confirm-message')}}')"
<?php } ?>
                                title="{{trans('<?=$gen->getLangAccess()?>/views.index.restore-row-button-label')}}">
                            <span class="fa fa-mail-reply"></span>
                            <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.restore-item-button')}}</span>
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
                        title="{{trans('<?=$gen->getLangAccess()?>/views.index.see-details-button-label')}}">
                        <span class="fa fa-eye"></span>
                        <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.see-details-button-label')}}</span>
                    </a>

                    {{-- Botón para ir a formulario de actualización del registro --}}
                    <a  href="{{route('<?=$gen->route()?>.edit', $record->id)}}"
                        class="btn btn-warning btn-xs" role="button"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="{{trans('<?=$gen->getLangAccess()?>/views.index.edit-item-button-label')}}">
                        <span class="glyphicon glyphicon-pencil"></span>
                        <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.edit-item-button-label')}}</span>
                    </a>

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
                                data-modalMessage="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-delete-message', ['item' => $record->name])}}"
                                data-modalTitle="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-delete-title')}}"
                                data-btnLabel="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-delete-btn-confirm-label')}}"
                                data-btnClassName="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-delete-btn-confirm-class-name')}}"
<?php } else { ?>
                                onclick="return confirm('{{ trans('<?=$gen->getLangAccess()?>/views.index.delete-confirm-message') }}')"
<?php } ?>
                                title="{{trans('<?=$gen->getLangAccess()?>/views.index.delete-item-button-label')}}">
                            <span class="fa fa-trash"></span>
                            <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.delete-item-button-label')}}</span>
                        </button>
                    
                    {!! Form::close() !!}
<?php if ($gen->hasDeletedAtColumn($fields)) { ?>
                @endif
<?php } ?>
                </td>
                    
            </tr>

            @empty

                <tr>
                    <td colspan="<?=count($fields)+2?>">
                        <div  class="alert alert-warning">
                        {{trans('<?=$gen->getLangAccess()?>/views.index.no-records-found')}}
                        </div>
                    </td>
                </tr>

            @endforelse

        </tbody>
    
    </table>
</div>

{!! $records->appends(Request::query())->render() !!}

<div>
    <strong>Notas:</strong>
    <ul>
        <li>Los registros que están "Eliminados", se muestran con <span class="bg-danger">Fondo Rojo</span>.</li>
    </ul>
</div>