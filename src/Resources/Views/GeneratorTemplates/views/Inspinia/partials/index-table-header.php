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

    <?= $gen->getViewCopyRightDocBlock() ?>
    
    ****************************************************************************
--}}

<tr class="header-row">
    @if(!isset($hide_checkboxes_column))
        <th class="checkbox-column"></th>
    @endif
<?php foreach ($fields as $field) { ?>
<?php if (!$field->hidden) { ?>
    @if(in_array('<?= $field->name ?>', $selectedTableColumns))
    <th class="<?= $field->name ?>">
        {!! UI::sortLink('<?=$gen->route()?>.index', trans('<?=$gen->getLangAccess()?>.table-columns.<?=$field->name?>'), '<?=$field->name?>') !!}
    </th>
    @endif
<?php } ?>
<?php } ?>
    @if(!isset($hide_actions_column))
        <th class="actions-column">{{trans('<?= $gen->solveSharedResourcesNamespace() ?>.table-actions-column')}}</th>
    @endif
</tr>
