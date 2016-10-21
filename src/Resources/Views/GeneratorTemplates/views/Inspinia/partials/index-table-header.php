<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
{{--
    ****************************************************************************
    Los nombres de las columnas de la tabla.
    ____________________________________________________________________________
    Aquí se muestran los nombres de columnas de la tabla, los cuales son enlaces
    que ordenan los resultados de la consulta ascendente o descendentemente.

    En caso de que se desee reutilizar esta vista y esconder la columna de los
    checkbox, al llamar esta vista enviar la variable:
    $hide_checkboxes_column = true

    Si se desea ocultar la columna de acciones, al llamar la vista enviar la
    variable:
    $hide_actions_column = true
    ****************************************************************************

    <?= $gen->getCopyRightDocBlock() ?>
    
    ****************************************************************************
--}}

<tr class="header-row">
    @if(!isset($hide_checkboxes_column))
    <th class="checkbox-column"></th>
    @endif
<?php foreach ($fields as $field) { ?>
<?php if (!$field->hidden) { ?>
    <th class="<?= $field->name ?>">
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
    @if(!isset($hide_actions_column))
    <th class="actions-column">{{trans('<?=$gen->getLangAccess()?>/views.index.table-actions-column')}}</th>
    @endif
</tr>
