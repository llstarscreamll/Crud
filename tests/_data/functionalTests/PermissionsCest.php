<?php

/**
 * Este archivo es parte de Books.
 * (c) Johan Alvarez <llstarscreamll@hotmail.com>
 * Licensed under The MIT License (MIT).
 *
 * @package    Books
 * @version    0.1
 * @author     Johan Alvarez
 * @license    The MIT License (MIT)
 * @copyright  (c) 2015-2016, Johan Alvarez <llstarscreamll@hotmail.com>
 * @link       https://github.com/llstarscreamll
 */

namespace Books;

use FunctionalTester;
use App\Models\Book;
use llstarscreamll\Core\Models\Role;
use llstarscreamll\Core\Models\Permission;
use Page\Functional\Books\Index as Page;

class PermissionsCest
{
    /**
     * El id del registro de prueba.
     *
     * @var  int
     */
    protected $bookId;

    /**
     * Las acciones a realizar antes de cada test.
     *
     * @param    FunctionalTester $I
     */
    public function _before(FunctionalTester $I)
    {
        new Page($I);
        $I->amLoggedAs(Page::$adminUser);

        $permissions = [
            'books.create',
            'books.edit',
            'books.destroy',
            'books.restore',
        ];

        // quitamos permisos de edición a los roles
        $permission = Permission::whereIn('slug', $permissions)->get(['id'])->pluck('id')->toArray();
        Role::all()->each(function ($item) use ($permission) {
            $item->permissions()->detach($permission);
        });

        // creamos registro de prueba
        $this->bookId = Page::haveBook($I);
    }

    /**
     * Prueba que las restricciones con los permisos de creación funcionen
     * correctamente.
     *
     * @param    FunctionalTester $I
     * @group    Books
     */ 
    public function createPermissions(FunctionalTester $I)
    {
        $I->wantTo('probar permisos de creación en módulo '.Page::$moduleName);

        // no debo ver link de acceso a página de creación en Index
        $I->amOnPage(Page::$moduleURL);
        $I->dontSee('Crear Libro', 'button.btn.btn-default.btn-sm');
        $I->dontSee('Crear Libro', 'a.btn.btn-default.btn-sm');

        // si intento acceder a la página soy redirigido al home de la app
        $I->amOnPage(Page::route('/create'));
        $I->seeCurrentUrlEquals('/home');
        $I->see('No tienes permisos para realizar esta acción.', '.alert.alert-warning');
    }

    /**
     * Prueba que las restricciones con los permisos de edición funcionen
     * correctamente.
     *
     * @param    FunctionalTester $I
     * @group    Books
     */ 
    public function editPermissions(FunctionalTester $I)
    {
        $I->wantTo('probar permisos de edición en módulo '.Page::$moduleName);

        // no debo ver link de acceso a página de edición en Index
        $I->amOnPage(Page::$moduleURL);
        $I->dontSee('Editar', 'tbody tr td a.btn.btn-warning.btn-xs');

        // el la página de detalles del registro no debo ver el link a página de
        // edición
        $I->amOnPage(Page::route("/$this->bookId"));
        $I->dontSee('Editar', '.form-group a.btn.btn-warning');

        // si intento acceder a la página de edición de un registro soy
        // redirigido al home de la app
        $I->amOnPage(Page::route("/$this->bookId/edit"));
        $I->seeCurrentUrlEquals('/home');
        $I->see('No tienes permisos para realizar esta acción.', '.alert.alert-warning');
    }

    /**
     * Prueba que las restricciones con los permisos de eliminación funcionen
     * correctamente.
     *
     * @param    FunctionalTester $I
     * @group    Books
     */ 
    public function deletePermissions(FunctionalTester $I)
    {
        $I->wantTo('probar permisos de eliminación en módulo '.Page::$moduleName);

        // no debo ver link de acceso a página de edición en Index
        $I->amOnPage(Page::$moduleURL);
        $I->dontSee('Mover a papelera', 'tbody tr td button.btn.btn-danger.btn-xs');
        $I->dontSee('Borrar Libros seleccionados', 'button.btn.btn-default.btn-sm');
        // en página de detalles del registro no debo ver botón "Mover a Papelera"
        $I->amOnPage(Page::route("/$this->bookId"));
        $I->dontSee('Mover a papelera', '.form-group button.btn.btn-danger');
    }

    /**
     * Prueba que las restricciones con los permisos de restauración de registros
     * registros en papelera funcionen correctamente.
     *
     * @param    FunctionalTester $I
     * @group    Books
     */ 
    public function restorePermissions(FunctionalTester $I)
    {
        $I->wantTo('probar permisos de restauración en módulo '.Page::$moduleName);

        // eliminamos el registro de prueba
        Book::destroy($this->bookId);

        // no debo ver link de acceso a página de edición en Index
        $I->amOnPage(Page::$moduleURL.'?trashed_records=withTrashed');
        $I->dontSee('Restaurar', 'tbody tr td button.btn.btn-success.btn-xs');
        $I->dontSee('Restaurar Libros seleccionados', 'button.btn.btn-default.btn-sm');
    }

}