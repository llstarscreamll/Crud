<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request Request */
?>
<?='<?php'?>

return [

    /**
     * Los mensajes de notificación cuando el usuario hace algún tipo de
     * transacción en el sistema, como crear/editar/borrar un modelo.
     */
    
    // mesajes del método store() del controlador
    'create_{{$gen->snakeCaseSingular()}}_success'               => '{{$request->get('single_entity_name')}} creado correctamente.',
    'create_{{$gen->snakeCaseSingular()}}_error'                 => 'Ocurrió un error creando el {{strtolower($request->get('single_entity_name'))}}.',

    // mesajes del método update() del controlador
    'update_{{$gen->snakeCaseSingular()}}_success'               => '{{$request->get('single_entity_name')}} actualizado correctamente.',
    'update_{{$gen->snakeCaseSingular()}}_error'                 => 'Ocurrió un error actualizando el {{strtolower($request->get('single_entity_name'))}}.',
    
    // mesajes del método destroy() del controlador
    'destroy_{{$gen->snakeCaseSingular()}}_success'              => 'El {{strtolower($request->get('single_entity_name'))}} ha sido movido a la papelera.|Los {{strtolower($request->get('plural_entity_name'))}} han sido movidos a la papelera correctamente.',
    'destroy_{{$gen->snakeCaseSingular()}}_error'                => 'Ocurrió un problema moviendo el {{strtolower($request->get('single_entity_name'))}} a la papelera.|Ocurrió un error moviendo los {{strtolower($request->get('plural_entity_name'))}} a la papelera.',

@if(($hasSoftDelete = $gen->hasDeletedAtColumn($fields)))
    // mesajes del método restore() del controlador
    'restore_{{$gen->snakeCaseSingular()}}_success'              => 'El {{strtolower($request->get('single_entity_name'))}} ha sido restaurado correctamente.|Los {{strtolower($request->get('plural_entity_name'))}} han sido restaurados correctamente.',
    'restore_{{$gen->snakeCaseSingular()}}_error'                => 'Ocurrió un problema restaurando el {{strtolower($request->get('single_entity_name'))}}.|Ocurrió un error restaurando los {{strtolower($request->get('plural_entity_name'))}}.',

@endif
];