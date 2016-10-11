<?php
namespace Page\Functional\Books;

use Page\Functional\Books\Base;

class Delete extends Base
{
    // include url of current page
    public static $URL = '/books';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    
    /**
     * Los atributos del botón de mover a la papelera.
     * @var  array
     */
    static $deleteBtn = array();

    /**
     * Los atributos del botón de confirmación de mover a la papelera.
     * @var  array
     */
    static $deleteBtnConfirm = array();

    /**
     * Los atributos del mensaje de confirmación de la operación.
     * @var  array
     */
    static $msgSuccess = array();

    /**
     * Los atributos del mensaje cuando no se encontran datos.
     * @var  array
     */
    static $msgNoDataFount = array();

    public function __construct(\FunctionalTester $I)
    {
        $this->functionalTester = $I;
        parent::__construct($I);

        self::$deleteBtn = [
            'txt'       => trans('book/views.show.btn-trash'),
            'selector'  => 'button.btn.btn-danger'
        ];

        self::$deleteBtnConfirm = [
            'txt'       => trans('book/views.show.modal-confirm-trash-btn-confirm'),
            'selector'  => 'form[name=delete-books-form] .btn.btn-danger'
        ];

        self::$msgSuccess = [
            'txt'       => trans_choice('book/messages.destroy_book_success', 1),
            'selector'  => '.alert.alert-success'
        ];

        self::$msgNoDataFount = [
            'txt'       => trans('book/views.index.no-records-found'),
            'selector'  => 'table .alert.alert-warning'
        ];
    }
}