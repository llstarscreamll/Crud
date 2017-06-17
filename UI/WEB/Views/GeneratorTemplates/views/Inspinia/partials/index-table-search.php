<?php
/* @var $crud App\Containers\Crud\Providers\TestsGenerator */
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

    <?= $crud->getViewCopyRightDocBlock() ?>
    
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
    @if(in_array('<?= $field->name ?>', $selectedTableColumns))
    <td class="<?= $field->name ?>">
        <?=$crud->getSearchUISetup($field, $crud->table_name)?>
    </td>
    @endif
<?php } ?>
<?php } ?>
    
    @if(!isset($hide_actions_column))
    {{-- Botones de búsqueda, limpieza del formulario y opciones de búsqueda --}}
    <td class="actions-column" style="min-width: 10em;">

        {{-- Más opciones de filtros --}}
        <div class="dropdown display-inline-table"
             data-toggle="tooltip"
             data-placement="top"
             title="{{ trans('<?= $crud->solveSharedResourcesNamespace() ?>.more-filters-btn') }}">
            
            <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <span class="sr-only">{{ trans('<?= $crud->solveSharedResourcesNamespace() ?>.more-filters-btn') }}</span>
                <span class="glyphicon glyphicon-filter"></span>
            </button>

            <ul class="dropdown-menu dropdown-menu-right prevent-hide" arialedby="dropdownMenu1">
                <li class="dropdown-header">{{ trans('<?= $crud->solveSharedResourcesNamespace() ?>.more-filters-btn') }}</li>
                <li role="separator" class="divider"></li>
<?php if ($crud->hasDeletedAtColumn($fields)) { ?>
                {{-- Con registros en papelera --}}
                <li>
                    <div class="checkbox">
                        <label>
                            {!! UISearch::searchField('radio', 'trashed_records', 'withTrashed', [], []) !!}
                            {{ trans('<?= $crud->solveSharedResourcesNamespace() ?>.filter-with-trashed') }}
                        </label>
                    </div>
                </li>
                {{-- Sólo registros en papelera --}}
                <li>
                    <div class="checkbox">
                        <label>
                            {!! UISearch::searchField('radio', 'trashed_records', 'onlyTrashed', [], []) !!}
                            {{ trans('<?= $crud->solveSharedResourcesNamespace() ?>.filter-only-trashed') }}
                        </label>
                    </div>
                </li>
<?php } ?>

                {{-- Las columnas de la tabla a mostrar u ocultar --}}
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">{{ trans('<?= $crud->solveSharedResourcesNamespace() ?>.more-filters-table-columns') }}</li>
                
                {!! UISearch::makeCheckboxesArray(
                    'table_columns[]',
                    trans('<?= $crud->getLangAccess() ?>.table-columns'),
                    $selectedTableColumns
                ) !!}

            </ul>
        </div>
        
        {{-- Ejecuta la búsqueda --}}
        <button type="submit"
                form="searchForm"
                class="btn btn-primary btn-sm"
                data-toggle="tooltip"
                data-placement="top"
                title="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.search-btn')}}">
            <span class="fa fa-search"></span>
            <span class="sr-only">{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.search-btn')}}</span>
        </button>

        {{-- Recarga la página restableciendo los campos de búsqueda --}}
        <a  href="{{route('<?=$crud->route()?>.index')}}"
            class="btn btn-danger btn-sm"
            role="button"
            data-toggle="tooltip"
            data-placement="top"
            title="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.clean-filters-btn')}}">
            <span class="glyphicon glyphicon-remove"></span>
            <span class="sr-only">{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.clean-filters-btn')}}</span>
        </a>

    </td>
    @endif
</tr>