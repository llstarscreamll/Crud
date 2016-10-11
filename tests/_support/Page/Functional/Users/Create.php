<?php
namespace Page\Functional\Users;

use Page\Functional\Users\Base;

class Create extends Base
{
	// include url of current page
    public static $URL = '/users/create';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    /**
     * Los atributos del título de la página.
     * @var  array
     */
    static $title = array();

    /**
     * El selector del formulario.
     * @var  string
     */
    static $form;

    /**
     * Los atributos del botón del formulario.
     * @var  array
     */
    static $formButton = array();

    /**
     * Mensaje de éxito al crear un registro.
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

        $this->initUIMap();
    }

    /**
     * Inicializa las variables del mapeo de la UI.
     * @return  void
     */
    public function initUIMap()
    {
    	self::$title = [
    		'txt' => trans('user/views.create.name'),
    		'selector'  => '.content-header h1 small'
    	];
		self::$form = 'form[name=create-users-form]';
		self::$formButton = [
			'txt' => trans('user/views.create.form-button'),
			'selector' => 'button.btn.btn-primary',
		];
		self::$msgSuccess = [
			'txt' => trans('user/messages.create_user_success'),
			'selector' => '.alert.alert-success'
		];
    }
}