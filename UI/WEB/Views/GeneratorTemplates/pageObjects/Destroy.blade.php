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
     * El botón de <?= strtolower($crud->getDestroyBtnTxt()) ?>.
     *
     * @var string
     */
    public static $<?= $crud->getDestroyVariableName() ?>Btn = '<?= $crud->getDestroyBtnTxt() ?>';
    public static $<?= $crud->getDestroyVariableName() ?>BtnElem = 'button.btn.btn-danger';

    /**
     * Botón de <?= strtolower($crud->getDestroyBtnTxt()) ?> varios registros.
     *
     * @var string
     */
    public static $<?= $crud->getDestroyVariableName() ?>ManyBtn = '<?= $crud->getDestroyManyBtnTxt() ?>';
    public static $<?= $crud->getDestroyVariableName() ?>ManyBtnElem = 'button.btn.btn-default.btn-sm';

    /**
     * Mensaje de éxito al <?= strtolower($crud->getDestroyBtnTxt()) ?> un registro.
     *
     * @var string
     */
    public static $msgSuccess = '<?= $crud->getDestroySuccessMsgSingle() ?>';
    public static $msgSuccessElem = '<?= config('modules.crud.uimap.alert-success-selector') ?>';

    public function __construct(FunctionalTester $I)
    {
        parent::__construct($I);
    }
}