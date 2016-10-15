<?php
namespace CRUD;

use CrudGenerator\FunctionalTester;
use CrudGenerator\Page\Functional\Generate as Page;

class GenerateModelCest
{
    public function _before(FunctionalTester $I)
    {
        new Page($I);
        $I->amLoggedAs(Page::$adminUser);
    }

    public function _after(FunctionalTester $I)
    {
    }

    /**
     * Comprueba las líneas de código generadas en el modelo del CRUD.
     * @param  FunctionalTester $I
     * @return void
     */
    public function checkModelCode(FunctionalTester $I)
    {
        $I->am('Developer');
        $I->wantTo('revisar las lineas de codigo del modelo');

        $I->amOnPage(Page::route('?table_name='.Page::$tableName));
        $I->see(Page::$title, Page::$titleElem);

        // envío el formulario de creación del CRUD
        $I->submitForm('form[name=CRUD-form]', Page::$formData);
        
        // abro el fichero del modelo generado
        $I->openFile('app/Models/Book.php');

        // veo las cláusula que tiene en cuenta los registros en papelera
        $I->seeInThisFile("\$request->has('trashed_records') and \$query->{\$request->get('trashed_records')}();");

        // veo el query por rango para los campos de fecha
        $I->seeInThisFile("\$request->get('published_year')['informative'] and \$query->whereBetween('published_year', [
            \$request->get('published_year')['from'],
            \$request->get('published_year')['to']
        ]);");

        $I->seeInThisFile("\$request->get('approved_at')['informative'] and \$query->whereBetween('approved_at', [
            \$request->get('approved_at')['from'],
            \$request->get('approved_at')['to']
        ]);");

        // veo las clausulas para el campo booleano enabled
        $I->seeInThisFile("\$request->get('enabled_true') and \$query->where('enabled', true);");
        $I->seeInThisFile("\$request->get('enabled_false') and \$query->orWhere('enabled', false);");

        // veo la propiedad con los valores enum de la columna status
        $I->seeInThisFile("/**
     * Los valores de la columna status que es de tipo enum, esto para los casos
     * en que sea utilizada una base de datos sqlite, pues sqlite no soporta campos de
     * tipo enum.
     * @var  string
     */
    static \$statusColumnEnumValues = \"enum('setting_documents','waiting_confirmation','reviewing','approved')\";");

        // veo la función que devuelve string de los valores enum de una columna de la base de datos con una
        // consulta desc table;
        $I->seeInThisFile("public static function getColumnEnumValuesFromDescQuery(\$table, \$column)
    {
        \$type = '';

        if (self::getDatabaseConnectionDriver() == 'mysql') {
            \$type = \DB::select( \DB::raw(\"SHOW COLUMNS FROM \$table WHERE Field = '\$column'\") )[0]->Type;
        } else {
            \$type = self::\${\$column.'ColumnEnumValues'};
        }

        return \$type;
    }");

        // veo la función que devuelve string del driver de la conexión a la base de datos
        $I->seeInThisFile("/**
     * Devuelve string del driver de la conexión a la base de datos.
     * @return  string El nombre del driver de la conexión a la base de datos.
     */
    public static function getDatabaseConnectionDriver()
    {
        return config('database.connections.'.config('database.default').'.driver');
    }");

        // veo la propiedad $connection comentada
        $I->seeInThisFile("/**
     * El nombre de la conexión a la base de datos del modelo.
     *
     * @var  string
     */
    //protected \$connection = 'connection-name';");
        
        // la propiedad que indeica cual es la llave primaria
        $I->seeInThisFile("/**
     * La llave primaria del modelo.
     * @var  string
     */
    protected \$primaryKey = 'id';");

        // compruebo reglas de validación
        $I->seeInThisFile("'status' => 'required|alpha_dash|in:'.self::getEnumValuesString('books', 'status').'',");

        // clausulas de búsqueda para info del index
        $I->seeInThisFile("\$request->get('name') and \$query->where('name', 'like', '%'.\$request->get('name').'%');");
        // clausulas para ordenar los datos
        $I->seeInThisFile("\$request->get('sort') and \$query->orderBy(\$request->get('sort'), \$request->get('sortType', 'asc'));");
        // los atributos asignables del modelo
        $I->seeInThisFile("protected \$fillable = [
        'reason_id',
        'name',
        'author',
        'genre',
        'stars',
        'published_year',
        'enabled',
        'status',
        'unlocking_word',
        'synopsis',
        'approved_at',
        'approved_by',
        'approved_password',
    ];");
        // las relaciones con los otros modelos
        $I->seeInThisFile("/**
     * La relación con App\Models\Reason
     * @return  object
     */
    public function reason()
    {
        return \$this->belongsTo('App\Models\Reason', 'reason_id');
    }");
        $I->seeInThisFile("/**
     * La relación con App\Models\User
     * @return  object
     */
    public function approvedBy()
    {
        return \$this->belongsTo('App\Models\User', 'approved_by');
    }");
    }
}
