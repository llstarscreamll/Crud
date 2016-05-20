<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request Request */
?>
<?='<?php'?>

namespace Page\Functional\{{$gen->studlyCasePlural()}};

@if($request->has('use_faker'))
use Faker\Factory as Faker;
@endif
use Page\Functional\{{$gen->studlyCasePlural()}}\Base;

class {{$test}} extends Base
{
	// include url of current page
    public static $URL = '/{{$gen->route()}}/create';

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
     * El selector del formulario.
     * @var string
     */
    static $form;

    /**
     * Los atributos del botón del formulario.
     * @var array
     */
    static $formButton = array();

    /**
     * Mensaje de éxito al crear un registro.
     * @var array
     */
    static $msgSuccess = array();

    /**
     * @var \FunctionalTester;
     */
    protected $functionalTester;

    public function __construct(\FunctionalTester $I)
    {
        $this->functionalTester = $I;
        parent::__construct($I);

        $this->initUIMap();
    }

    /**
     * Inicializa las variables del mapeo de la UI.
     * @return void
     */
    public function initUIMap()
    {
    	self::$title = [
    		'txt' => trans('{{$gen->getLangAccess()}}/views.create.name'),
    		'selector'  => '{{config('llstarscreamll.CrudGenerator.uimap.title-selector')}}'
    	];
		self::$form = 'form[name=create-{{$gen->getDashedModelName()}}-form]';
		self::$formButton = [
			'txt' => trans('{{$gen->getLangAccess()}}/views.create.form-button'),
			'selector' => '{{config('llstarscreamll.CrudGenerator.uimap.create-form-button-selector')}}',
		];
		self::$msgSuccess = [
			'txt' => trans('{{$gen->getLangAccess()}}/messages.create_{{$gen->snakeCaseSingular()}}_success'),
			'selector' => '{{config('llstarscreamll.CrudGenerator.uimap.msg-success-selector')}}'
		];
    }
}