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
     * Los atributos del link de acceso a la edición de capacitación.
     * @var array
     */
    static $linkToEdit = array();
    
    /**
     * Los atributos del título de la página.
     * @var array
     */
    static $title = array();

    /**
     * El selector del formulario de edición.
     * @var string
     */
    static $form = 'form[name=edit-{{$gen->getDashedModelName()}}-form]';

    /**
     * Los atributos del mensaje de confirmación de la operación.
     * @var array
     */
    static $msgSuccess = array();

    public function __construct(\FunctionalTester $I)
    {
        $this->functionalTester = $I;
        parent::__construct($I);

        self::$linkToEdit = [
	        'txt'       => trans('{{$gen->getLangAccess()}}/views.edit.link-access'),
	        'selector'  => '{{config('llstarscreamll.CrudGenerator.uimap.edit-link-access-selector')}}'
    	];

    	self::$title = [
	        'txt'       => trans('{{$gen->getLangAccess()}}/views.edit.name'),
	        'selector'  => '{{config('llstarscreamll.CrudGenerator.uimap.edit-title-selector')}}'
	    ];

	    self::$msgSuccess = [
	        'txt'       => trans('{{$gen->getLangAccess()}}/messages.update_{{$gen->snakeCaseSingular()}}_success'),
	        'selector'  => '{{config('llstarscreamll.CrudGenerator.uimap.edit-message-success-selector')}}'
	    ];
    }

    /**
     * Devuelve un array con los datos que deben estar presentes en el formulario de edición
     * del modelo antes de su actualización.
     * @return array
     */
    public static function getUpdateFormData()
    {
    	$data = self::getCreateData();

    	foreach (self::getCreateData() as $key => $create_field) {
            
            if (! isset(self::$updateFormFields[$key])) {
                unset($data[$key]);
            }

        }

        return $data;
    }

    /**
     * Devuelve un array con datos para actualización del formulario de edición del modelo.
     * @return array
     */
    public static function getDataToUpdateForm()
    {
    	$data = array();

    	$data = [
    	@foreach($fields as $field)
        @if($field->on_update_form_field)
            '{{$field->name}}' => {!!$field->testDataUpdate!!},
        @endif
        @endforeach
        ];

        return $data;
    }

}