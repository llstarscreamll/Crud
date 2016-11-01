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

class {{$test}} extends Index
{
    /**
     * El botón de {{ strtolower($gen->getDestroyBtnTxt()) }}.
     *
     * @var string
     */
    static ${{ $gen->getDestroyVariableName() }}Btn = '{{ $gen->getDestroyBtnTxt() }}';
    static ${{ $gen->getDestroyVariableName() }}BtnElem = 'button.btn.btn-danger';

    /**
     * Botón de {{ strtolower($gen->getDestroyBtnTxt()) }} varios registros.
     *
     * @var string
     */
    static ${{ $gen->getDestroyVariableName() }}ManyBtn = '{{ $gen->getDestroyManyBtnTxt() }}';
    static ${{ $gen->getDestroyVariableName() }}ManyBtnElem = 'button.btn.btn-default.btn-sm';

    /**
     * Mensaje de éxito al {{ strtolower($gen->getDestroyBtnTxt()) }} un registro.
     *
     * @var string
     */
    static $msgSuccess = '{{ $gen->getDestroySuccessMsgSingle() }}';
    static $msgSuccessElem = '{{ config('modules.CrudGenerator.uimap.alert-success-selector') }}';

    public function __construct(FunctionalTester $I)
    {
        parent::__construct($I);
    }
}