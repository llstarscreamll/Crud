<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
{{--
    ****************************************************************************
    Los campos del formulario de búsqueda de tabla.
    ____________________________________________________________________________
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

<tr class="search-row">
    @if(!isset($hide_checkboxes_column))
    <td class="checkbox-column">
        {!! Form::checkbox('check_all', 'check_all', null, ['id' => 'check_all']) !!}
    </td>
    @endif
<?php foreach ($fields as $field) { ?>
<?php if (!$field->hidden) { ?>
    <td class="<?= $field->name ?>">
        <?=$gen->getSearchUISetup($field, $gen->table_name)?>
    </td>
<?php } ?>
<?php } ?>
    
    @if(!isset($hide_actions_column))
    {{-- Botones de búsqueda, limpieza del formulario y opciones de búsqueda --}}
    <td class="actions-column" style="min-width: 10em;">

        {{-- Más opciones de filtros --}}
        <div class="dropdown display-inline-table"
             data-toggle="tooltip"
             data-placement="top"
             title="{{ trans('<?=$gen->getLangAccess()?>/views.index.filters-button-label') }}">
            
            <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <span class="sr-only">{{ trans('<?=$gen->getLangAccess()?>/views.index.filters-button-label') }}</span>
                <span class="glyphicon glyphicon-filter"></span>
            </button>

            <ul class="dropdown-menu dropdown-menu-right prevent-hide" aria-labelledby="dropdownMenu1">
                <li class="dropdown-header">{{ trans('<?=$gen->getLangAccess()?>/views.index.filters-button-label') }}</li>
                <li role="separator" class="divider"></li>
<?php if ($gen->hasDeletedAtColumn($fields)) { ?>
                {{-- Con registros en papelera --}}
                <li>
                    <div class="checkbox">
                        <label>
                            {!! UI::searchField('radio', 'trashed_records', 'withTrashed', [], []) !!}
                            {{ trans('<?=$gen->getLangAccess()?>/views.index.filter-with-trashed-label') }}
                        </label>
                    </div>
                </li>
                {{-- Sólo registros en papelera --}}
                <li>
                    <div class="checkbox">
                        <label>
                            {!! UI::searchField('radio', 'trashed_records', 'onlyTrashed', [], []) !!}
                            {{ trans('<?=$gen->getLangAccess()?>/views.index.filter-only-trashed-label') }}
                        </label>
                    </div>
                </li>
<?php } ?>
            </ul>
        </div>
        
        {{-- Ejecuta la búsqueda --}}
        <button type="submit"
                form="searchForm"
                class="btn btn-primary btn-sm"
                data-toggle="tooltip"
                data-placement="top"
                title="{{trans('<?=$gen->getLangAccess()?>/views.index.search-button-label')}}">
            <span class="fa fa-search"></span>
            <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.search-button-label')}}</span>
        </button>

        {{-- Recarga la página restableciendo los campos de búsqueda --}}
        <a  href="{{route('<?=$gen->route()?>.index')}}"
            class="btn btn-danger btn-sm"
            role="button"
            data-toggle="tooltip"
            data-placement="top"
            title="{{trans('<?=$gen->getLangAccess()?>/views.index.clean-filter-button-label')}}">
            <span class="glyphicon glyphicon-remove"></span>
            <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.clean-filter-button-label')}}</span>
        </a>

    </td>
    @endif
</tr>