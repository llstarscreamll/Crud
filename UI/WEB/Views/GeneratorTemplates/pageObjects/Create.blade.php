<?php
/* @var $crud App\Containers\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $crud->getClassCopyRightDocBlock() ?>


namespace Page\Functional\<?= $crud->studlyCasePlural() ?>;

use FunctionalTester;

class <?= $test ?> extends Index
{
    /**
     * La URL de la página.
     *
     * @var string
     */
    public static $URL = '/<?= $crud->route() ?>/create';

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
    public static $form = 'form[name=create-<?= $crud->getDashedModelName() ?>-form]';

    /**
     * El botón submit del formulario.
     *
     * @var array
     */
    public static $formBtnElem = '<?=config('modules.crud.uimap.create-form-button-selector') ?>';

    /**
     * Mensaje de éxito al crear un registro.
     *
     * @var array
     */
    public static $msgSuccess = '<?= $crud->getStoreSuccessMsg() ?>';
    public static $msgSuccessElem = '<?= config('modules.crud.uimap.alert-success-selector') ?>';

    public function __construct(FunctionalTester $I)
    {
        parent::__construct($I);
    }
}