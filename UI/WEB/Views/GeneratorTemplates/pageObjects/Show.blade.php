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
     * El título de la página.
     *
     * @var string
     */
    public static $title = 'Detalles';

    /**
     * El selector del formulario de sólo lectura de los datos.
     *
     * @var string
     */
    public static $form = 'form[name=show-<?= $crud->getDashedModelName() ?>-form]';

    public function __construct(FunctionalTester $I)
    {
        parent::__construct($I);
    }
}
