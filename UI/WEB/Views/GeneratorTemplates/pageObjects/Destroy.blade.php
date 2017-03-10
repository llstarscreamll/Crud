<?php
/* @var $gen App\Containers\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


namespace Page\Functional\<?= $gen->studlyCasePlural() ?>;

use FunctionalTester;

class <?= $test ?> extends Index
{
    /**
     * El botón de <?= strtolower($gen->getDestroyBtnTxt()) ?>.
     *
     * @var string
     */
    public static $<?= $gen->getDestroyVariableName() ?>Btn = '<?= $gen->getDestroyBtnTxt() ?>';
    public static $<?= $gen->getDestroyVariableName() ?>BtnElem = 'button.btn.btn-danger';

    /**
     * Botón de <?= strtolower($gen->getDestroyBtnTxt()) ?> varios registros.
     *
     * @var string
     */
    public static $<?= $gen->getDestroyVariableName() ?>ManyBtn = '<?= $gen->getDestroyManyBtnTxt() ?>';
    public static $<?= $gen->getDestroyVariableName() ?>ManyBtnElem = 'button.btn.btn-default.btn-sm';

    /**
     * Mensaje de éxito al <?= strtolower($gen->getDestroyBtnTxt()) ?> un registro.
     *
     * @var string
     */
    public static $msgSuccess = '<?= $gen->getDestroySuccessMsgSingle() ?>';
    public static $msgSuccessElem = '<?= config('modules.crud.uimap.alert-success-selector') ?>';

    public function __construct(FunctionalTester $I)
    {
        parent::__construct($I);
    }
}