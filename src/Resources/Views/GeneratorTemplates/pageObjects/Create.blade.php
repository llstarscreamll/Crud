<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


namespace Page\Functional\{{$gen->studlyCasePlural()}};

use FunctionalTester;
@if($request->has('use_faker'))
use Faker\Factory as Faker;
@endif

class {{$test}} extends Index
{
    /**
     * La URL de la página.
     *
     * @var string
     */
    public static $URL = '/{{$gen->route()}}/create';

    /**
     * El título de la página.
     *
     * @var string
     */
    public static $title = 'Crear';

    /**
     * El enlace botón para ir a formulario de creación. El selector puede ser
     * un link <a> o un botón <button>, pero la clase es la misma en los dos.
     *
     * @var string
     */
    public static $createBtn = 'Crear {!!$request->get('single_entity_name')!!}';
    public static $createBtnElem = '.btn.btn-default.btn-sm';

    /**
     * El selector del formulario.
     *
     * @var string
     */
    public static $form = 'form[name=create-{{$gen->getDashedModelName()}}-form]';

    /**
     * El botón submit del formulario.
     *
     * @var array
     */
    public static $formBtnElem = '{{config('modules.CrudGenerator.uimap.create-form-button-selector')}}';

    /**
     * Mensaje de éxito al crear un registro.
     *
     * @var array
     */
    public static $msgSuccess = '{{ $gen->getStoreSuccessMsg() }}';
    public static $msgSuccessElem = '{{ config('modules.CrudGenerator.uimap.alert-success-selector') }}';

    public function __construct(FunctionalTester $I)
    {
        parent::__construct($I);
    }
}