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
    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    
    /**
     * El título de la página.
     * @var array
     */
    static $title = array();

    /**
     * El selector de la tabla donde se listan los registros.
     * @var string
     */
    static $table = '{{config('modules.CrudGenerator.uimap.index-table-selector')}}';

    public function __construct(\FunctionalTester $I)
    {
        parent::__construct($I);

        self::$title = [
            'txt'       => trans('{{$gen->getLangAccess()}}/views.module.name'),
            'selector'  => '{{config('modules.CrudGenerator.uimap.module-title-selector')}}'
        ];
    }

    /**
     * Obtiene los datos que deben estar en la tabla del index, es decir que tenemos que extraer
     * los datos legibles para usuario de las llaves foráneas de la entidad.
     * @return array
     */
    public static function getIndexTableData()
    {
        $data = self::${{$gen->modelVariableName()}}Data;

        // los datos de las llaves foráneas
@foreach($fields as $field)
@if($field->namespace)
        $data['{{ $field->name }}'] = \{{ $field->namespace }}::find($data['{{ $field->name }}'])->name;
@endif
@endforeach
        
        // los atributos ocultos no deben mostrarse en la tabla del index
        foreach (static::$hiddenFields as $key => $attr) {
            if (isset($data[$attr]) === true) unset($data[$attr]);
        }

        return $data;
    }
}