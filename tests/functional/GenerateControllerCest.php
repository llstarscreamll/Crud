<?php
namespace CRUD;

use CrudGenerator\FunctionalTester;
use CrudGenerator\Page\Functional\Generate as Page;

class GenerateControllerCest
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
     * Comprueba las líneas de código generadas en el controlador del CRUD.
     * @param  FunctionalTester $I
     * @return void
     */
    public function checkControllerCode(FunctionalTester $I)
    {
        $I->am('Developer');
        $I->wantTo('revisar las lineas de codigo del controlador');

        $I->seeAuthentication();
        //$I->amOnRoute('crudGenerator.showOptions');
        $I->amOnPage(Page::route('?table_name='.Page::$tableName));
        $I->see(Page::$title, Page::$titleElem);

        // envío el formulario de creación del CRUD
        $I->submitForm('form[name=CRUD-form]', Page::$formData);

        // reviso que se esté llamando a las clases de los modelos de las que
        // depende el controlador correctamente
        $I->openFile(base_path().'/app/Http/Controllers/BookController.php');

        /////////////////////////////////////////////////////////////////////////////////////
        // TODO: compribar que en el método show() del controlador sólo se pasen los datos //
        // necesarios de los modelos relacionados a la entidad                             //
        /////////////////////////////////////////////////////////////////////////////////////
        
        $I->seeInThisFile("public function show(Request \$request, \$id)
    {
        // los datos para la vista
        \$data = array();
        \$data['book'] = Book::findOrFail(\$id);

        \$data['approved_by_list'] = (\$user = User::where('id', \$data['book']->approved_by)->first())
            ? \$user->pluck('name', 'id')->all()
            : [];

        \$data['reason_id_list'] = (\$reason = Reason::where('id', \$data['book']->reason_id)->first())
            ? \$reason->pluck('name', 'id')->all()
            : [];

        \$data['status_list'] = Book::getEnumValuesArray('books', 'status');
        
        return \$this->view(\"show\", \$data);
    }");

        $I->seeInThisFile("\$data['reason_id_list'] = Reason::pluck('name', 'id')->all();");
        $I->seeInThisFile("use App\Models\Reason;");
        $I->seeInThisFile("use llstarscreamll\Core\Models\User;");

        // se le debe pasar una instancia de Request a la método de consulta de datos para el index
        $I->seeInThisFile("\$data['records'] = Book::findRequested(\$request);");
        // los datos Json de las tablas dependientes y columnas de tipo enum
        $I->seeInThisFile("\$data['status_list_json'] = collect(\$data['status_list'])
            ->map(function (\$item, \$key) { return [\$key => \$item];})
            ->values()
            ->toJson();");
        $I->seeInThisFile("\$data['reason_id_list_json'] = collect(\$data['reason_id_list'])
            ->map(function (\$item, \$key) { return [\$key => \$item];})
            ->values()
            ->toJson();");

        // veo el método restore en el controlador
        $I->seeInThisFile("/**
     * Restore the specified resource from storage.
     * @param  \Illuminate\Http\Request \$request
     * @param  string \$id
     * @return  \Illuminate\Http\Response
     */
    public function restore(Request \$request, \$id)
    {
        \$id = \$request->has('id') ? \$request->get('id') : \$id;

        Book::onlyTrashed()->whereIn('id', \$id)->restore()
            ? \$request->session()->flash('success', trans_choice('book/messages.restore_book_success', count(\$id)))
            : \$request->session()->flash('error', trans_choice('book/messages.restore_book_error', count(\$id)));

        return redirect()->route('books.index');
    }");
    }
}
