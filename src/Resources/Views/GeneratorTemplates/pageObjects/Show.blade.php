<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request Request */
?>
<?='<?php'?>

namespace Page\Functional\{{$gen->studlyCasePlural()}};

use Page\Functional\{{$gen->studlyCasePlural()}}\Base;

class {{$test}} extends Base
{
    // include url of current page
    public static $URL = '/{{$gen->route()}}';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    
    /**
     * Los atributos del título de la página.
     * @var array
     */
    static $title = array();

    /**
     * El selector del formulario de sólo lectura de los datos.
     * @var string
     */
    static $form = 'form[name=show-{{$gen->getDashedModelName()}}-form]';

    public function __construct(\FunctionalTester $I)
    {
        parent::__construct($I);

        self::$title = [
            'txt'       => trans('{{$gen->getLangAccess()}}/views.show.name'),
            'selector'  => '{{config('modules.CrudGenerator.uimap.show-title-selector')}}'
        ];
    }

    /**
     * Devuelve array con los datos a visualizar en el formulario de sólo lectura.
     * @return array
     */
    public static function getReadOnlyFormData()
    {
        $data = self::${{$gen->modelVariableName()}}Data;

        // los siguientes campos no se han de mostrar en la vista de sólo lectura
        foreach (self::$hiddenFields as $key => $value) {
            unset($data[$value]);
        }

        return $data;
    }
}