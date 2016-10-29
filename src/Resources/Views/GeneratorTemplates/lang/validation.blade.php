<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request [] */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


return [

    /**
     * Los nombres de los campos y mensajes de validación de formularios en los
     * Form Requests.
     */

    // Los nombres de los atributos para validación en Form Requests.
    'attributes' => [
@foreach($fields as $field)
        '<?= $field->name ?>' => '<?= $field->label ?>',
@if(strpos($field->validation_rules, 'confirmed'))
        '{{$field->name}}_confirmation' => 'Confirmar {!!$field->label!!}',
@endif
@endforeach

@foreach($fields as $field)
<?php if ($field->type == 'date' || $field->type == 'timestamp' || $field->type == 'datetime') { ?>
        '<?= $field->name ?>[from]' => '<?= $field->label ?> inicial',
        '<?= $field->name ?>[to]' => '<?= $field->label ?> final',
<?php } elseif ($field->type == "tinyint") { ?>
        '<?= $field->name ?>_true' => '<?= $field->label ?> si',
        '<?= $field->name ?>_false' => '<?= $field->label ?> no',
<?php } else { ?>
        '<?= $field->name ?>' => '<?= $field->label ?>',
<?php } ?>
@endforeach

    ],

    // Los mensajes personalizados de validación en Form Requests.
    'messages' => [
        'foo' => 'msg'
    ],
];
