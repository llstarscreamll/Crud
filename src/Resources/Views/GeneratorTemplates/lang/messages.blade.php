<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


return [

    /**
     * Los mensajes de notificación cuando el usuario hace algún tipo de
     * transacción en el sistema, como crear/editar/borrar un registro.
     */
    
    // mesajes del método store() del controlador
    'create_{{$gen->snakeCaseSingular()}}_success' => '{{ $gen->getStoreSuccessMsg() }}',
    'create_{{$gen->snakeCaseSingular()}}_error' => '{{ $gen->getStoreErrorMsg() }}',

    // mesajes del método update() del controlador
    'update_{{$gen->snakeCaseSingular()}}_success' => '{{ $gen->getUpdateSuccessMsg() }}',
    'update_{{$gen->snakeCaseSingular()}}_error' => '{{ $gen->getUpdateErrorMsg() }}',
    
    // mesajes del método destroy() del controlador
    'destroy_{{$gen->snakeCaseSingular()}}_success' => '{{ $gen->getDestroySuccessMsgSingle() }}|{{ $gen->getDestroySuccessMsgPlural() }}',
    'destroy_{{$gen->snakeCaseSingular()}}_error' => '{{ $gen->getDestroyErrorMsgSingle() }}|{{ $gen->getDestroyErrorMsgPlural() }}',

@if(($hasSoftDelete = $gen->hasDeletedAtColumn($fields)))
    // mesajes del método restore() del controlador
    'restore_{{$gen->snakeCaseSingular()}}_success' => '{{ $gen->getRestoreSuccessMsgSingle() }}|{{ $gen->getRestoreSuccessMsgPlural() }}',
    'restore_{{$gen->snakeCaseSingular()}}_error' => '{{ $gen->getRestoreErrorMsgSingle() }}|{{ $gen->getRestoreErrorMsgPlural() }}',

@endif
];