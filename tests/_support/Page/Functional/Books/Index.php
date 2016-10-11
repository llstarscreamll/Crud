<?php
namespace Page\Functional\Books;

use Page\Functional\Books\Base;

class Index extends Base
{
    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    
    /**
     * El título de la página.
     * @var  array
     */
    static $title = array();

    /**
     * El selector de la tabla donde se listan los registros.
     * @var  string
     */
    static $table = '.table.table-hover';

    public function __construct(\FunctionalTester $I)
    {
        $this->functionalTester = $I;
        parent::__construct($I);

        self::$title = [
            'txt'       => trans('book/views.module.name'),
            'selector'  => '.content-header h1'
        ];
    }
}