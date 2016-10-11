<?php
namespace Page\Functional\Users;

use Page\Functional\Users\Base;

class Edit extends Base
{
    // include url of current page
    public static $URL = '/users';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    
    /**
     * Los atributos del link de acceso a la edición de capacitación.
     * @var  array
     */
    static $linkToEdit = array();
    
    /**
     * Los atributos del título de la página.
     * @var  array
     */
    static $title = array();

    /**
     * El selector del formulario de edición.
     * @var  string
     */
    static $form = 'form[name=edit-users-form]';

    /**
     * Los atributos del mensaje de confirmación de la operación.
     * @var  array
     */
    static $msgSuccess = array();

    /**
     * @var  \FunctionalTester;
     */
    protected $functionalTester;

    public function __construct(\FunctionalTester $I)
    {
        $this->functionalTester = $I;
        parent::__construct($I);

        self::$linkToEdit = [
	        'txt'       => trans('user/views.edit.link-access'),
	        'selector'  => 'a.btn.btn-warning'
    	];

    	self::$title = [
	        'txt'       => trans('user/views.edit.name'),
	        'selector'  => '.content-header h1 small'
	    ];

	    self::$msgSuccess = [
	        'txt'       => trans('user/messages.update_user_success'),
	        'selector'  => '.alert.alert-success'
	    ];
    }

    /**
     * Devuelve un array con los datos que deben estar presentes en el formulario de edición
     * del modelo antes de su actualización.
     * @return  array
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
     * @return  array
     */
    public static function getDataToUpdateForm()
    {
    	$data = array();

    	$data = [
    	                                    'name' => 'Alan',
                                    'lastname' => 'Silvestri',
                                    'email' => 'alan@silvesti.com',
                                                    'activated' => false,
                                                                                        ];

        return $data;
    }

}