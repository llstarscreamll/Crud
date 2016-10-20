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
        parent::__construct($I);

        self::$title = [
            'txt'       => trans('book/views.module.name'),
            'selector'  => '.content-header h1'
        ];
    }

    /**
     * Obtiene los datos que deben estar en la tabla del index, es decir que tenemos que extraer
     * los datos legibles para usuario de las llaves foráneas de la entidad.
     * @return  array
     */
    public static function getIndexTableData()
    {
        $data = self::$bookData;

        // los datos de las llaves foráneas
        $data['reason_id'] = \App\Models\Reason::find($data['reason_id'])->name;
        $data['approved_by'] = \llstarscreamll\Core\Models\User::find($data['approved_by'])->name;
        
        // los atributos ocultos no deben mostrarse en la tabla del index
        foreach (static::$hiddenFields as $key => $attr) {
            if (isset($data[$attr]) === true) unset($data[$attr]);
        }

        return $data;
    }
}